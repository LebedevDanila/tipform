FROM emerinov/php-apache:v2

WORKDIR /var/www/html

RUN mkdir public && echo "Hello" > /var/www/html/public/index.php
RUN echo "Listen 8080" > /etc/apache2/ports.conf
COPY ./config/supervisor /etc/supervisor/conf.d/
COPY ./config/000-default.conf /etc/apache2/sites-available/

RUN a2enmod rewrite
RUN service apache2 restart

COPY --chown=www-data:www-data system_ /var/www/html/system/
COPY --chown=www-data:www-data composer.json /var/www/html/composer.json

RUN composer self-update --2
RUN composer install --no-dev

COPY --chown=www-data:www-data . /var/www/html

RUN rm -R system_ && chmod -R 777 writable && chmod 777 kube_deploy.sh && chmod 777 kube_job.sh && chmod 777 kube_cronjob.sh && chmod 777 kube_deploy_queue.sh

EXPOSE 8080
