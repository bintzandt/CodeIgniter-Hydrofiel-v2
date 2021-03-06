<?= $this->extend('email/template'); ?>
<?= $this->section('content') ?>
    <p>Lieve <?= $user->name ?>,</p>
    <p>
        Ik heb zojuist je inschrijving verwerkt en je bent vanaf vandaag officieel lid! Dit betekent dat je toegang hebt
        tot de Hydrofiel website. Met <a href="<?= site_url('/reset-password') . '?token=' . $user->recoveryToken ?>">deze</a>
        link kun je een account aanmaken op <a href="<?= site_url('') ?>">www.hydrofiel.nl</a>. Op de website zie je
        onder andere de agenda en kan je jezelf inschrijven voor activiteiten/toernooien/wedstrijden. Tevens vind je
        daar het HR en de statuten en andere nuttige informatie.
    </p>
    <p>
        Ook krijg je voortaan de nieuwsbrief, andere belangrijke mails en blijf je op de hoogte van alle gebeurtenissen!
    </p>
    <p>De trainingen zijn als volgt verdeeld:</p>
    <div style="overflow-x: auto;">
        <table class="training">
            <thead>
            <tr>
                <th></th>
                <th>Maandag</th>
                <th>Dinsdag</th>
                <th>Donderdag</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Zwemmen</td>
                <td>-</td>
                <td>20:00-21:00</td>
                <td>20:00-21:00</td>
            </tr>
            <tr>
                <td>Waterpolo Dames</td>
                <td>21:30-22:30</td>
                <td>-</td>
                <td>21:00-22:30</td>
            </tr>
            <tr>
                <td>Waterpolo Heren 1 & 2</td>
                <td>-</td>
                <td>21:00-22:30</td>
                <td>21:30-22:30</td>
            </tr>
            <tr>
                <td>Waterpolo Heren 3 & recreatief</td>
                <td>-</td>
                <td>21:00-22:00</td>
                <td>21:00-22:00</td>
            </tr>
            </tbody>
        </table>
    </div>
<?php
if ( ! empty($events)) { ?>
    <p>
        <b>Aankomende evenementen:</b>
    </p>
    <ul>
        <?php
        foreach ($events as $event) { ?>
            <li><a href="<?= site_url('event/' . $event->eventId) ?>"><?= $event->nameNL ?>
                    op <?= $event->from->format('d-m-Y H:i') ?></a></li>
            <?php
        } ?>
    </ul>
<?php
}
?>
    <p>
        In de bijlage vind je onze welkomstbrief. Mocht je nog vragen hebben, dan hoor ik deze graag. Dit kan
        persoonlijk of via een mailtje naar <a href="mailto:secretaris@hydrofiel.nl">secretaris@hydrofiel.nl</a>.
    </p>
    <p>
        Vergeet ons vooral niet te liken op Facebook: <a href="https://www.facebook.com/Hydrofiel/">https://www.facebook.com/Hydrofiel/</a>
    </p>
    <p>
        Tot in het bad!
    </p>
    <p>
        Met Harde en Natte groet,
    </p>
    <p>
        Iris Harmsen<br>
        <i>
            Secretaris 2020-2021<br>
            N.S.Z.&W.V. Hydrofiel
        </i>
    </p>
    <footer></footer>
<?= $this->endSection() ?>
