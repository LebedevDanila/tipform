# Add default kubeconfig file
mkdir ~/.kube && cp $KUBECONFIG ~/.kube/config

# Download Kubectl
apk add --update --no-cache curl git
curl -LO https://storage.googleapis.com/kubernetes-release/release/`curl -s https://storage.googleapis.com/kubernetes-release/release/stable.txt`/bin/linux/amd64/kubectl    # Download kubectl binary
chmod +x ./kubectl
mv ./kubectl /usr/local/bin/kubectl

# Download skaffold
curl -Lo skaffold https://storage.googleapis.com/skaffold/releases/latest/skaffold-linux-amd64
chmod +x ./skaffold
mv ./skaffold /usr/local/bin/skaffold

# Wait to start docker
while (! docker stats --no-stream ); do echo "Waiting for Docker to launch..."; sleep 1; done

# Kubectl preparing
kubectl create namespace $KUBE_NAMESPACE --dry-run=client -o yaml | kubectl apply -f -
kubectl config set-context --current --namespace=$KUBE_NAMESPACE
kubectl delete secret gitlab-registry --ignore-not-found=true
kubectl create secret docker-registry gitlab-registry --docker-server="$CI_REGISTRY" --docker-username="$CI_DEPLOY_USER" --docker-password="$CI_DEPLOY_PASSWORD" --docker-email="$GITLAB_USER_EMAIL" -o yaml --dry-run=client | kubectl apply -f -
kubectl delete jobs --all --ignore-not-found=true
echo "$CI_REGISTRY_PASSWORD" | docker login -u "$CI_REGISTRY_USER" "$CI_REGISTRY" --password-stdin

sed -i "s/\$CI_PROJECT_PATH_SLUG/${CI_PROJECT_PATH_SLUG}/g" kube-manifests/*
sed -i "s/\$CI_ENVIRONMENT_SLUG/${CI_ENVIRONMENT_SLUG}/g" kube-manifests/*
sed -i "s/\$KUBE_INGRESS_BASE_DOMAIN/${KUBE_INGRESS_BASE_DOMAIN}/g" kube-production/*

# Add PROD ENV
echo ${FRONTEND_ENV} | base64 -d > kube-configs/frontend.yaml

# Apply kube-configs, kube-production
kubectl apply -f kube-configs/
kubectl apply -f kube-production/

# Skaffold RUN
skaffold --default-repo=$CI_REGISTRY/$CI_PROJECT_PATH --namespace=$KUBE_NAMESPACE run