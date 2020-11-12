<!DOCTYPE html>
<html>
<body>
<div style="width: 100%; margin:0 auto;" align="center">
    <table cellspacing="0" cellpadding="0" width="100%">
        <tr style="background: #ffab3a; height: 120px; color: #FFFFFF; font-size:25px; padding: 7px; ">
            <td align="center"><img src="<?= site_url('images/logomail.png') ?>" alt="Logo" height="100px"
                                    style="float:left; align-content: center"></td>
            <td style="padding-right: 10px"><br/>
                <h2><?= $engels ? "Hydrofiel Newsletter" : "Hydrofiel Nieuwsbrief" ?></h2></td>
        </tr>
        <tr>
            <td rowspan="2" valign="top" style="text-align:left;"><?= $content ?></td>
            <td style="background:#213947; font-size: 20px; padding: 5px; width: 150px; height:40px;"><a
                        href="<?= site_url('/event/') ?>" style="color:#FFAB3A; text-decoration: none">
                    <h3><?= $engels ? "Calendar" : "Agenda" ?></h3></a></td>
        </tr>
        <tr>
            <td style="color:#FFFFFF; background:#315265; padding: 5px;" valign="top">
                <?php
                if ( ! empty($events)) {
                    foreach ($events as $event) { ?>
                        <div>
							<span><a href="<?= site_url('/event/' . $event->eventId) ?>" style="color: #FFF;"><img
                                            style="padding-right: 5px" width="16px" height="16px"
                                            src="<?= site_url(
                                                '/images/mail/calendar.png'
                                            ) ?>"><?= $engels ? $event->nameEN : $event->nameNL ?></a></span><br/>
                            <?= $punt->from->format('d-m-Y H:i') ?>
                        </div><br/>

                        <?php
                    }
                } ?></td>
        </tr>
        <tr>
            <td style="color: #FFFFFF; background: #315265; padding: 7px;" height="50" colspan="2"></td>
        </tr>
    </table>
</div>
</body>
</html>
