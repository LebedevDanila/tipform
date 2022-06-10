<div class="adminAccounts admin">
    <div class="admin__popup js__adminAccountsPopupDelete">
        <div class="admin__popup-content flex-ajc">
            <img class="admin__popup-close js__adminAccountsPopupDeleteClose" src="/static/img/pages/adminAccounts/close.svg" alt="close">
            <div class="admin__popup-title">Вы точно хотите удалить этот аккаунт?</div>
            <div class="admin__popup-buttons flex">
                <div class="admin__popup-button flex-ajc _yes js__adminAccountsDeleteAccept">Да</div>
                <div class="admin__popup-button flex-ajc _no js__adminAccountsDeleteDecline">Нет</div>
            </div>
        </div>
    </div>
    <div class="admin__popup admin__popupAdd js__adminAccountsPopupAdd">
        <div class="admin__popup-content">
            <img class="admin__popup-close js__adminAccountsPopupAddClose" src="/static/img/pages/adminAccounts/close.svg" alt="close">
            <div class="admin__popup-title">Добавление нового аккаунта</div>
            <div class="admin__popup-field">
                <div class="admin__popup-label">Логин:</div>
                <input class="admin__popup-input js__adminAccountsLogin" type="text" placeholder="Разрешены только цифры, буквы и _">
            </div>
            <div class="admin__popup-field">
                <div class="admin__popup-label">Пароль:</div>
                <input class="admin__popup-input js__adminAccountsPassword" type="text" placeholder="*********">
            </div>
            <div class="admin__popup-field">
                <div class="admin__popup-label">Прокси ip:</div>
                <input class="admin__popup-input js__adminAccountsProxyIp" type="text" placeholder="70.100.12.100:37">
            </div>
            <div class="admin__popup-field">
                <div class="admin__popup-label">Прокси логин:</div>
                <input class="admin__popup-input js__adminAccountsProxyLogin" type="text" placeholder="Логин от прокси">
            </div>
            <div class="admin__popup-field">
                <div class="admin__popup-label">Прокси пароль:</div>
                <input class="admin__popup-input js__adminAccountsProxyPassword" type="text" placeholder="Пароль от прокси">
            </div>
            <button class="admin__popup-submit admin__btn js__adminAccountsSubmit">Добавить аккаунт</button>
        </div>
    </div>
    <div class="admin__other container">
        <div class="admin__title">Аккаунты:</div>
        <div class="admin__btn adminAccounts__add js__adminAccountsAdd">Добавить аккаунт</div>
    </div>
    <table class="admin__table" border-spacing="0">
        <thead>
            <tr>
                <th>№</th>
                <th>Логин:</th>
                <th>Пароль:</th>
                <th>Статус:</th>
                <th>Дата создания:</th>
                <th>Дата активности:</th>
                <th>Прокси ip:</th>
                <th>Прокси логин:</th>
                <th>Прокси пароль:</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($accounts as $idx => $row): ?>
                <tr>
                    <?php $status = $row->status === '1' ? true : false; ?>
                    <td data-label="№"><?= $idx + 1 ?></td>
                    <td data-label="Логин:" class="title"><?= $row->login ?></td>
                    <td data-label="Пароль:"><?= $row->password ?></td>
                    <td class="action">
                        <button class="status <?= $status ? '_active' : '_close' ?>"><?= $status ? 'Активен' : 'Не активен' ?></button>
                    </td>
                    <td data-label="Дата создания:"><?= date("d.m.Y H:i", $row->date_create) ?></td>
                    <td data-label="Дата активности:"><?= date("d.m.Y H:i", $row->date_last_action) ?></td>
                    <td data-label="Прокси ip:"><?= $row->proxy_ip ?></td>
                    <td data-label="Прокси логин:"><?= $row->proxy_login ?></td>
                    <td data-label="Прокси пароль:"><?= $row->proxy_password ?></td>
                    <td class="action">
                        <button class="<?= !$status ? '_enable' : '_disable' ?> js__adminAccountsSwitchStatus" data-id="<?= $row->id ?>" data-action="<?= !$status ? 'enable' : 'disable' ?>"><?= !$status ? 'Включить' : 'Отключить' ?></button>
                    </td>
                    <td class="action"><button class="_delete js__adminAccountsDelete" data-id="<?= $row->id ?>">Удалить</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
