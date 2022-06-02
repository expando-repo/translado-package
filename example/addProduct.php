<?php

    use Expando\TransladoPackage\Request\ProductRequest;
    use Expando\TransladoPackage\Request\VariantRequest;

    require_once 'boot.php';

    $translado = new \Expando\TransladoPackage\Translado();
    $translado->setToken($_SESSION['translado_token'] ?? null);
    $translado->setUrl($_SESSION['client_data']['translado_url']);
    if ($translado->isTokenExpired()) {
        $translado->refreshToken($_SESSION['client_data']['client_id'], $_SESSION['client_data']['client_secret']);
        if ($translado->isLogged()) {
            $_SESSION['translado_token'] = $translado->getToken();
        }
    }

    if (!$translado->isLogged()) {
        die('Translator is not logged');
    }

    if ($_POST['send'] ?? null) {
        try {
            $product = new ProductRequest($_POST['connection_id'] ?? null, $_POST['product_id'] ?: null);
            $product->active();
            $product->setIdentifier($_POST['identifier']);
            $product->setTitle($_POST['product_title']);
            $product->setDescription($_POST['product_description']);
            $product->setDescription2($_POST['product_description2'] ?? null);
            $product->setUrl($_POST['url'] ?? null);

            foreach ($_POST['brands'] ?? [] as $brand) {
                if ($brand) {
                    $product->addBrand($brand);
                }
            }

            foreach ($_POST['tags'] ?? [] as $tag) {
                if ($tag) {
                    $product->addTag($tag);
                }
            }

            $i = 0;
            foreach ($_POST['images'] ?? [] as $url) {
                if ($url) {
                    $product->addImageUrl($url, $i++, $i === 1);
                }
            }

            foreach ($_POST['categories'] ?? [] as $value) {
                if ($value) {
                    $product->addCategory($value);
                }
            }

            foreach ($_POST['variant'] ?? [] as $value) {
                if ($value['title'] ?? null) {
                    $variant = new VariantRequest();
                    $variant->setIdentifier($value['identifier']);
                    $variant->setPrice($value['price']);
                    $variant->setVat(21);
                    $variant->setEan($value['ean']);
                    $variant->setTitle($value['title']);
                    $variant->setDescription($value['description']);
                    $variant->setImageUrl($value['image']);
                    $variant->setStock($value['stock']);
                    foreach ($value['options_variant'] ?? [] as $option) {
                        if ($option['name'] && $option['value']) {
                            $variant->addOption($option['name'], $option['value'], true);
                        }
                    }
                    foreach ($value['options'] ?? [] as $option) {
                        if ($option['name'] && $option['value']) {
                            $variant->addOption($option['name'], $option['value']);
                        }
                    }
                    $product->addVariant($variant);
                }
            }
            $response = $translado->send($product);
        }
        catch (\Expando\TransladoPackage\Exceptions\TransladoException $e) {
            die($e->getMessage());
        }

        echo 'Product ID: ' . $response->getProductId() . '<br /><br />';
    }
?>

<form method="post">
    <div>
        <label>
            Connection ID<br />
            <input type="text" name="connection_id" value="<?php echo $_POST['connection_id'] ?? '' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Product ID (pokud bude vyplněno bude updatovat)<br />
            <input type="text" name="product_id" value="<?php echo $_POST['product_id'] ?? '' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Identifier<br />
            <input type="text" name="identifier" value="<?php echo $_POST['identifier'] ?? '13946' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Product title<br />
            <input type="text" name="product_title" value="<?php echo $_POST['product_title'] ?? 'Pánská košile' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Product description<br />
            <textarea name="product_description"><?php echo $_POST['product_description'] ?? 'Tato košile má klasický rovný střih a dlouhé rukávy se zapínáním na klasické knoflíky. Volnější rovný střih je vhodný pro muže všech typů postav. Poskytne vám dostatek prostoru pro pohodlné nošení a navíc dokáže šikovně skrýt i případné nedokonalosti postavy. Pokud dáváte v módě přednost klasickému stylu, pak je pro vás tato košile ideální volbou. Díky univerzálnímu střihu a elegantnímu balení může být zároveň jedinečným dárkem, kterým muže opravdu potěšíte.' ?></textarea>
        </label>
    </div>
    <div>
        <label>
            Product description2<br />
            <textarea name="product_description2"></textarea>
        </label>
    </div>
    <div>
        <label>
            Url produktu<br />
            <input type="text" name="url" value="<?php echo $_POST['url'] ?? 'https://www.willsoor.cz/p/13946-panska-klasicka-kosile-s-tmave-modrym-kostkovanym-vzorem/' ?>"  />
        </label>
    </div>
    <br />
    <br />
    <div>
        <label>
            Brand 1<br />
            <input type="text" name="brands[]" value="<?php echo $_POST['brands'][0] ?? 'Willsoor' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Brand 2<br />
            <input type="text" name="brands[]" value="<?php echo $_POST['brands'][1] ?? '' ?>"  />
        </label>
    </div>
    <br />
    <br />
    <div>
        <label>
            Tag 1<br />
            <input type="text" name="tags[]" value="<?php echo $_POST['tags'][0] ?? 'Sleva' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Tag 2<br />
            <input type="text" name="tags[]" value="<?php echo $_POST['tags'][1] ?? 'Novinka' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Tag 3<br />
            <input type="text" name="tags[]" value=""  />
        </label>
    </div>
    <br />
    <br />
    <div>
        <label>
            Category 1<br />
            <input type="text" name="categories[]" value="<?php echo $_POST['categories'][0] ?? 'WILLSOOR' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Category 2<br />
            <input type="text" name="categories[]" value="<?php echo $_POST['categories'][1] ?? 'PÁNSKÉ KOŠILE' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Category 3<br />
            <input type="text" name="categories[]" value="<?php echo $_POST['categories'][2] ?? 'KLASICKÉ KOŠILE' ?>"  />
        </label>
    </div>
    <br />
    <br />
    <div>
        <label>
            Image URL 1<br />
            <input type="text" name="images[]" value="<?php echo $_POST['images'][0] ?? 'https://www.willsoor.cz/images/produkty/thumb/13946img_9263_4_1.jpg' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Image URL 2<br />
            <input type="text" name="images[]" value="<?php echo $_POST['images'][1] ?? 'https://www.willsoor.cz/images/produkty/thumb2/13946img_9265_5_1.jpg' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Image URL 3<br />
            <input type="text" name="images[]" value="<?php echo $_POST['images'][2] ?? '' ?>"  />
        </label>
    </div>
    <br />
    <br />
    <h2>Varianta 1</h2>
    <div>
        <label>
            Identifier<br />
            <input type="text" name="variant[1][identifier]" value="<?php echo $_POST['variant'][1]['identifier'] ?? 'KXXL24' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Title<br />
            <input type="text" name="variant[1][title]" value="<?php echo $_POST['variant'][1]['title'] ?? 'Pánská košile modrá XXL' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Description<br />
            <textarea name="variant[1][description]"><?php echo $_POST['variant'][1]['description'] ?? '' ?></textarea>
        </label>
    </div>
    <div>
        <label>
            Price<br />
            <input type="text" name="variant[1][price]" value="<?php echo $_POST['variant'][1]['price'] ?? '1526' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Stock<br />
            <input type="text" name="variant[1][stock]" value="<?php echo $_POST['variant'][1]['stock'] ?? '24' ?>"  />
        </label>
    </div>
    <div>
        <label>
            EAN<br />
            <input type="text" name="variant[1][ean]" value="<?php echo $_POST['variant'][1]['ean'] ?? '5901223208523' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Image URL<br />
            <input type="text" name="variant[1][image]" value="<?php echo $_POST['variant'][1]['image'] ?? 'https://www.willsoor.cz/images/produkty/thumb/13946img_9263_4_1.jpg' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option 1 (tvoří variantu)<br />
            <input type="text" name="variant[1][options_variant][1][name]" value="<?php echo $_POST['variant'][1]['options_variant'][1]['name'] ?? 'Barva' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option value 1 (tvoří variantu)<br />
            <input type="text" name="variant[1][options_variant][1][value]" value="<?php echo $_POST['variant'][1]['options_variant'][1]['value'] ?? 'Modrá' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option 2 (tvoří variantu)<br />
            <input type="text" name="variant[1][options_variant][2][name]" value="<?php echo $_POST['variant'][1]['options_variant'][2]['name'] ?? 'Velikost' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option value 2 (tvoří variantu)<br />
            <input type="text" name="variant[1][options_variant][2][value]" value="<?php echo $_POST['variant'][1]['options_variant'][2]['value'] ?? 'XXL' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option 3<br />
            <input type="text" name="variant[1][options][3][name]" value="<?php echo $_POST['variant'][1]['options'][3]['name'] ?? 'Rukáv' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option 3<br />
            <input type="text" name="variant[1][options][3][value]" value="<?php echo $_POST['variant'][1]['options'][3]['value'] ?? 'dlouhý' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option 4<br />
            <input type="text" name="variant[1][options][4][name]" value="<?php echo $_POST['variant'][1]['options'][4]['name'] ?? 'Pohlaví' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option 4<br />
            <input type="text" name="variant[1][options][4][value]" value="<?php echo $_POST['variant'][1]['options'][4]['value'] ?? 'pánská' ?>"  />
        </label>
    </div>
    <br />
    <br />
    <h2>Varianta 2</h2>
    <div>
        <label>
            Identifier<br />
            <input type="text" name="variant[2][identifier]" value="<?php echo $_POST['variant'][2]['identifier'] ?? 'KXS24' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Title<br />
            <input type="text" name="variant[2][title]" value="<?php echo $_POST['variant'][2]['title'] ?? 'Pánská košile modrá XS' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Description<br />
            <textarea name="variant[2][description]"><?php echo $_POST['variant'][2]['description'] ?? '' ?></textarea>
        </label>
    </div>
    <div>
        <label>
            Price<br />
            <input type="text" name="variant[2][price]" value="<?php echo $_POST['variant'][2]['price'] ?? '1526' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Stock<br />
            <input type="text" name="variant[2][stock]" value="<?php echo $_POST['variant'][2]['stock'] ?? '14' ?>"  />
        </label>
    </div>
    <div>
        <label>
            EAN<br />
            <input type="text" name="variant[2][ean]" value="<?php echo $_POST['variant'][2]['ean'] ?? '5901223208523' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Image URL<br />
            <input type="text" name="variant[2][image]" value="<?php echo $_POST['variant'][2]['image'] ?? 'https://www.willsoor.cz/images/produkty/thumb/13946img_9263_4_1.jpg' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option 1 (tvoří variantu)<br />
            <input type="text" name="variant[2][options_variant][1][name]" value="<?php echo $_POST['variant'][2]['options_variant'][1]['name'] ?? 'Barva' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option value 1 (tvoří variantu)<br />
            <input type="text" name="variant[2][options_variant][1][value]" value="<?php echo $_POST['variant'][2]['options_variant'][1]['value'] ?? 'Modrá' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option 2 (tvoří variantu)<br />
            <input type="text" name="variant[2][options_variant][2][name]" value="<?php echo $_POST['variant'][2]['options_variant'][2]['name'] ?? 'Velikost' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option value 2 (tvoří variantu)<br />
            <input type="text" name="variant[2][options_variant][2][value]" value="<?php echo $_POST['variant'][2]['options_variant'][2]['value'] ?? 'XS' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option 3<br />
            <input type="text" name="variant[2][options][3][name]" value="<?php echo $_POST['variant'][2]['options'][3]['name'] ?? 'Rukáv' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option 3<br />
            <input type="text" name="variant[2][options][3][value]" value="<?php echo $_POST['variant'][2]['options'][3]['value'] ?? 'dlouhý' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option 4<br />
            <input type="text" name="variant[2][options][4][name]" value="<?php echo $_POST['variant'][2]['options'][4]['name'] ?? 'Pohlaví' ?>"  />
        </label>
    </div>
    <div>
        <label>
            Option 4<br />
            <input type="text" name="variant[2][options][4][value]" value="<?php echo $_POST['variant'][2]['options'][4]['value'] ?? 'pánská' ?>"  />
        </label>
    </div>

    <div>
        <input type="submit" name="send" value="send" />
    </div>
</form>
