<?= $this->extend('templates/default'); ?>
<?= $this->section('body') ?>
    <div class="row">
        <div class="col-md-2 d-none d-md-block">
            <a href="https://www.sponsorkliks.com/winkels.php?club=8634" target="_blank" rel="noopener"><img
                        class="rounded" style="margin: 0 auto;" src="/images/sponsorkliks.gif"
                        alt="SponsorKliks, gratis sponsoren!" title="SponsorKliks, sponsor jouw sponsordoel gratis!"
                        Border="0"></a>
        </div>
        <!--
            -->
        <div class="col-md-10">
            <p>
                <?= lang('Home.homeWelcome'); ?>
            </p>
            <p>
                <?= lang('Home.homeSponsor'); ?>
            </p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md homepage_block">
            <a href="/agenda">
                <h3><?= lang('Home.homeEvents') ?></h3>
            </a>
            <?php
            if ( ! empty($upcomingEvents)) {
                foreach ($upcomingEvents as $event) { ?>
                    <div>
                        <span class="far fa-calendar"></span><a
                                href="/event/<?= $event->eventId ?>"> <?= $event->name ?></a><br>
                        <div class="pl-3"><?= $event->from->format('d-m-Y H:i') ?></div>
                    </div>
                <?php
                }
            } else { ?>
                <span class="fa fa-frown-open"></span> <?= lang('Home.homeNoEvents') ?>
            <?php
            } ?>
        </div>
        <div class="col-md homepage_block">
            <h3><?= lang('Home.homeBirthdays') ?></h3>
            <?php
            if (isLoggedIn()) : ?>
                <?php
                foreach ($upcomingBirthdays as $verjaardag) { ?>
                    <div>
                        <span class="fa fa-birthday-cake"></span><a
                                href="/user/<?= $verjaardag->userId ?>"> <?= $verjaardag->name ?>
                            (<?= date('Y') - $verjaardag->geboortejaar ?>)</a><br>
                        <div class="pl-3"><?= $verjaardag->geboortedatum ?></div>
                    </div>
                <?php
                } ?>
            <?php
            else : ?>
                <span class="fa fa-birthday-cake"></span> <a href="<?= route_to('login') ?> "><?= lang(
                        'Home.homeLogin'
                    ); ?></a>
            <?php
            endif; ?>
        </div>
    </div>
<?php
if (isset($posts) && ! empty($posts)) { ?>
    <hr>
    <h3><?= lang('Home.homeNews') ?></h3>
    <?php
    foreach ($recentPosts as $post) { ?>
        <h4><?= $post->title ?></h4>
        <div class="row">
            <?php
            if ($post->image !== "") { ?>
                <div class='col-lg pb-lg-3'>
                    <img class="img-fluid" src="<?= $post->image ?>">
                </div>
                <div class="col-lg-9 pt-md-2 pt-sm-2">
                    <?= $post->text ?>
                </div>
            <?php
            } else { ?>
                <div class="col-lg" align="left">
                    <?= $post->text ?>
                </div>
            <?php
            } ?>
            <hr>
        </div>
    <?php
    }
    ?>
<?php
} ?>
<?= $this->endSection() ?>
