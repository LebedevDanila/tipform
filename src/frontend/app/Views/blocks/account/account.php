<a class="account flex-a <?= $z['class'] ?? '' ?>" href="/profile/<?= $z['username'] ?>">
    <?php if (!empty($z['delete_class'])): ?>
        <svg data-username="<?= $z['username'] ?>" class="account__delete <?= $z['delete_class'] ?>" width="20"
             height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 5L5 15" stroke="#CD3870" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M15 15L5 5" stroke="#CD3870" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    <?php endif; ?>
    <?php if (!empty($z['add_class'])): ?>
        <svg
            data-username="<?= $z['username'] ?>"
            data-picture="<?= $z['picture'] ?>"
            data-followers="<?= $z['followers'] ?>"
            class="account__add <?= $z['add_class'] ?> <?= !empty($z['is_favorite']) && $z['is_favorite'] !== false ? '_active' : '' ?>"
            width="20"
            height="20"
            viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
        >
            <path d="M9.99935 16.6042C9.99935 16.6042 2.83789 12.5938 2.83789 7.72396C2.83804 6.86325 3.13628 6.02916 3.6819 5.36349C4.22753 4.69782 4.98686 4.24166 5.8308 4.07258C6.67474 3.9035 7.55119 4.03192 8.31115 4.43602C9.0711 4.84012 9.66764 5.49494 9.99936 6.28917L9.99934 6.28917C10.3311 5.49495 10.9276 4.84012 11.6876 4.43602C12.4475 4.03192 13.324 3.9035 14.1679 4.07258C15.0118 4.24166 15.7712 4.69782 16.3168 5.36349C16.8624 6.02916 17.1607 6.86325 17.1608 7.72396C17.1608 12.5938 9.99935 16.6042 9.99935 16.6042Z"
                  stroke="#CD3870" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    <?php endif; ?>
    <div class="account__image">
        <img src="<?= $z['picture'] ?>" alt="">
    </div>
    <div class="account__content">
        <div class="account__username"><?= $z['username'] ?></div>
        <div class="account__followers">
            <span><?= createShortNumber($z['followers']) ?></span> подписчиков
        </div>
    </div>
</a>
