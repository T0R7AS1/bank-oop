<?php

class Operations {
    public function store($data){
        $saskaitos = new JsonConfig;
        $saskaitele = $saskaitos->connect();
        if (empty($data['vardas'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Vardas yra privalomas</h5>
            </div>
            <?php
            return;
        }
        if (empty($data['pavarde'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Pavarde yra privaloma</h5>
            </div>
            <?php
            return;
        }
        if (empty($data['saskaita'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Saskaitos numeris yra privalomas</h5>
            </div>
            <?php
            return;
        }
        if (empty($data['asmens_kodas'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Asmens kodas yra privalomas</h5>
            </div>
            <?php
            return;
        }
        if (strlen($data['vardas']) < 3) {
            ?>
            <div class="alert alert-danger">
                <h5>Vardas turi buti ilgesnis nei 3 simboliai</h5>
            </div>
            <?php
            return;
        }
        if (strlen($data['pavarde']) < 3) {
            ?>
            <div class="alert alert-danger">
                <h5>Pavarde turi buti ilgesne nei 3 simboliai</h5>
            </div>
            <?php
            return;
        }
        if (strlen($data['asmens_kodas']) != 11) {
            ?>
            <div class="alert alert-danger">
                <h5>Asmens kodas turi buti 11 simboliu ilgio</h5>
            </div>
            <?php
            return;
        }
        if (ctype_alpha(str_replace(' ', '', $data['vardas'])) === false) {
            ?>
            <div class="alert alert-danger">
                <h5>Vardas gali susidaryti tik is raidziu :)</h5>
            </div>
            <?php
            return;
        }
          if (ctype_alpha(str_replace(' ', '', $data['pavarde'])) === false) {
            ?>
            <div class="alert alert-danger">
                <h5>Pavarde gali susidaryti tik is raidziu :)</h5>
            </div>
            <?php
            return;
        }
        if (!is_numeric($data['saskaita'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Saskaitos numeryje gali buti tik skaiciai :)</h5>
            </div>
            <?php
            return;
        }
        if (!is_numeric($data['asmens_kodas'])) {
            ?>
            <div class="alert alert-danger">
                <h5>Asmens kode gali buti tik skaiciai :)</h5>
            </div>
            <?php
            return;
        }
        $data['id'] = rand(10000,2000000);
        foreach ($saskaitele as $key => $value) {
            if ($value['asmens_kodas'] == $data['asmens_kodas']) {
                ?>
                <div class="alert alert-danger">
                    <h5>Toks asmens kodas jau yra</h5>
                </div>
                <?php
                return;
            }
            while ($value['id'] == $data['id']) {
                $data['id']++;
            }
        }
        foreach ($saskaitele as $key => $value) {
            while ($value['id'] == $data['id']) {
                $data['id']++;
            }
        }
        $data['vardas'] = str_replace(' ', '',$data['vardas']);
        $data['pavarde'] = str_replace(' ', '',$data['pavarde']);
        $data['vardas'] = ucfirst(strtolower($data['vardas']));
        $data['pavarde'] = ucfirst(strtolower($data['pavarde']));
        $data['likutis'] = 0;
        $saskaitele[] = $data;
        usort($saskaitele, function ($a, $b) {
            return $a['pavarde'] <=> $b['pavarde'];
        });
        file_put_contents(__DIR__.'/saskaitos.json', json_encode($saskaitele));
        header('Location: index.php?create=success');
    }
    public function getId($id){
        $saskaitos = new JsonConfig;
        $saskaitele = $saskaitos->connect();
        foreach ($saskaitele as $val) {
            if ($val['id'] == $id) {
                return $val;
            }
        }
        return null;
    }
    public function removeFromSum($data, $id){
        $saskaitos = new JsonConfig;
        $saskaitele = $saskaitos->connect();
        foreach ($saskaitele as $key => $value) {
            if ($value['id'] == $id) {
                (double)$value['likutis'] -= number_format((double)$data['likuti'], 2, '.', '');
                if ($data['likuti'] > $value['likutis']) {
                    $value['likutis'] = 0;
                }
                $saskaitele[$key] = $value;
                if (!$data['likuti']) {
                    ?>
                    <div class="alert alert-danger">
                        <h5>Iveskite suma kiek norite nuskaiciuoti arba eikite atgal</h5>
                    </div>
                    <?php
                    return;
                }
                if ($data['likuti'] < 0) {
                    ?>
                    <div class="alert alert-danger">
                        <h5>Is saskaitos negalima nuskaiciuoti minusines sumos </h5>
                    </div>
                    <?php
                    return;
                }
                if (!is_numeric($data['likuti'])) {
                    ?>
                    <div class="alert alert-danger">
                        <h5>Is saskaitos negalima nuimti raidziu arba simboliu nes ju nera :) (jeigu raset su kableliu prasome naudoti taskeli)</h5>
                    </div>
                    <?php
                    return;
                }else{
                    if ($value['likutis'] == 0) {
                        header("Location: index.php?rem=all");
                    }else{
                        header("Location: index.php?rem=success");
                    }
                    file_put_contents(__DIR__.'/saskaitos.json', json_encode($saskaitele));
                }
            }
        }
    }
    public function addToSum($data, $id){
        $saskaitos = new JsonConfig;
        $saskaitele = $saskaitos->connect();
        foreach ($saskaitele as $key => $value) {
            if ($value['id'] == $id) {
                if (!$data['likuti']) {
                    ?>
                    <div class="alert alert-danger">
                        <h5>Iveskite suma kiek norite prideti arba eikite atgal</h5>
                    </div>
                    <?php
                    return;
                }
                if ($data['likuti'] < 0) {
                    ?>
                    <div class="alert alert-danger">
                        <h5>I saskaita negalima prideti minusines sumos </h5>
                    </div>
                    <?php
                    return;
                }
                if (!is_numeric($data['likuti'])) {
                    ?>
                    <div class="alert alert-danger">
                        <h5>I saskaita negalima prideti raidziu arba simboliu :) (jeigu raset su kableliu prasome naudoti taskeli)</h5>
                    </div>
                    <?php
                    return;
                }else{
                    (double)$value['likutis'] += number_format((double)$data['likuti'], 2, '.', '');
                    $saskaitele[$key] = $value;
                    file_put_contents(__DIR__.'/saskaitos.json', json_encode($saskaitele));
                    header("Location: index.php?add=success");
                }
            }
        }
    }
    public function delete($id){
        $saskaitos = new JsonConfig;
        $saskaitele = $saskaitos->connect();
        foreach ($saskaitele as $key => $value) {
            if ($value['id'] == $id) {
                if ($value['likutis'] == 0) {
                    array_splice($saskaitele, $key, 1);
                }else{
                    header('Location: index.php?delete=error');
                    return;
                }
            }
        }
        header('Location: index.php?delete=success');
        file_put_contents(__DIR__.'/saskaitos.json', json_encode($saskaitele));
    }
    public function messages($url){
        if (strpos($url, "create=success") == true) {
            ?>
            <div class="alert alert-success">
            <h5>Vartotojas buvo sukurtas sekmingai</h5>
            </div>
            <?php
        }
        if (strpos($url, "delete=error") == true) {
            ?>
            <div class="alert alert-danger">
            <h5>Negalima istrinti vartotojo nes jo saskaitoje yra lesu</h5>
            </div>
            <?php
        }
        if (strpos($url, "delete=success") == true) {
            ?>
            <div class="alert alert-success">
            <h5>Vartotojas buvo istrintas sekmingai</h5>
            </div>
            <?php
        }
        if (strpos($url, "add=success") == true) {
            ?>
            <div class="alert alert-success">
            <h5>Vartotojui lesos buvo pridetos sekmingai</h5>
            </div>
            <?php
        }
        if (strpos($url, "rem=success") == true) {
            ?>
            <div class="alert alert-success">
            <h5>Vartotojui lesos buvo nuskaiciuotos sekmingai</h5>
            </div>
            <?php
        }
        if (strpos($url, "rem=all") == true) {
            ?>
            <div class="alert alert-success">
            <h5>Vartotojui lesos buvo nuskaiciuotos sekmingai dabar jo saskaita yra lygi nuliui ir ja galima istrinti</h5>
            </div>
            <?php
        }
    }
}

?>