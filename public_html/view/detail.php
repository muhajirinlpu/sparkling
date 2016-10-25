<?php
$content  = _run("SELECT * FROM `contens` WHERE  slug = ?",[$_GET['title']]);
if($content->rowCount() != 1) _redirect("./");
$content = _get($content,1);
$_SESSION['TMP']['contents_id'] = $content['contents_id'];
$pictures = _get(_run("SELECT * FROM pictures WHERE contents_id = ?",[$content['contents_id']]));
$date = date_create($content['create_at']);
$rate = _get(_run("SELECT AVG(val) FROM rates WHERE contents_id = ?",[$content['contents_id']]),1)["AVG(val)"];
?>
<style>
    .container{
        margin-right: 350px;
    }
</style>
<div class="container" style="margin-top: 70px">
    <center><h1><?= $content['title'] ?></h1></center>
    <pre class="fun-text">
        <?= $content['descrip'] ?>
    </pre>
    <div class="picture">
        <?php foreach ($pictures AS $val): ?>
            <img src="./assets/pic/<?= $val['pic_name'] ?>" alt="" class="fun-pic">
        <?php endforeach; ?>
    </div>
    <div class="">
        <h2 class="fun-heading">Beri rating</h2>
        <div class="form-orange">
            <form action="./prcs.php?user&do=giveRate" method="post">
                <select name="val" id="">
                    <?php
                    $lonely_rate = _get(_run("SELECT val FROM rates WHERE author = ? AND contents_id = ?",[$_SESSION['userdata']['users_id'],$_SESSION['TMP']['contents_id']]),1)['val'];
                    $kriteria_rate = ["sangat buruk","buruk","biasa","baik","sangat baik"];
                    foreach($kriteria_rate AS $key=>$value){
                        $stat = "";
                        if($lonely_rate == $key+1) $stat = "selected";
                        echo "<option {$stat} value='".($key+1)."'>{$value}</option>";
                    }
                    ?>
                </select>
                <input type="submit">
            </form>
        </div>
        <h2 class="fun-heading">Komentar</h2>
    </div>
</div>
<div class="right-content">
    <div class="extra-content">
        <p>Di publis pada <?= date_format($date,"D, d F Y ") ?> </p>
        <p>Rating : <?= $rate ?></p>
    </div>
</div>