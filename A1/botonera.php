<!-- botonera.php -->
<div class="botonera">
    
    <form action="<?= $_SERVER["PHP_SELF"] . '?periodo=' . $periodo . '&conta=' . ($conta - $ls_periodos[$periodo]) ?>" method="post" class="botonI">
        <input type="submit" value="<?= $periodo . '_anterior' ?>" class="presione">
    </form>

    <div class='spacer'></div>

    <form action="<?= $_SERVER["PHP_SELF"] . '?periodo=semana&conta=' . $conta ?>" method="post" class="periodo">
        <input type="submit" value="semana" class="<?= $ref_class[$class[0]] ?>">
    </form>

    

    <form action="<?= $_SERVER["PHP_SELF"] . '?periodo=dia&conta=' . $conta ?>" method="post" class="periodo">
        <input type="submit" value="dia" class="<?= $ref_class[$class[1]] ?>">
    </form>

    <form action="<?= $_SERVER["PHP_SELF"] . '?periodo=hora&conta=' . $conta ?>" method="post" class="periodo">
        <input type="submit" value="hora" class="<?= $ref_class[$class[2]] ?>">
    </form>

    <div class='spacer'></div>

    <form action="<?= $_SERVER["PHP_SELF"] . '?periodo=' . $periodo . '&conta=' . ($conta + $ls_periodos[$periodo]) ?>" method="post" class="botonD">
        <input type="submit" value="<?= $periodo . '_siguiente' ?>" class="presione">
    </form>

    <form action="<?= $_SERVER["PHP_SELF"] . '?periodo=' . $periodo ?>" method="post" class="fin">
        <input type="submit" value='>|' class="presione">
    </form>
</div>
