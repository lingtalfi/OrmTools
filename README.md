OrmTools
=============
2017-08-30


Some tools helping with construction of orms.



This is part of the [universe framework](https://github.com/karayabin/universe-snapshot).


Install
==========
Using the [uni](https://github.com/lingtalfi/universe-naive-importer) command.
```bash
uni import OrmTools
```

Or just download it and place it where you want otherwise.




Why?
=======
I'm tired of typing the fields of a table to build my self made orm objects manually.



How to
==========

```php
<?php

use Core\Services\A;
use OrmTools\Util\CopyPasteUtil;


require_once __DIR__ . "/../boot.php";
require_once __DIR__ . "/../init.php";



A::quickPdoInit(); // initializing QuickPdo, this depends on your application
$util = CopyPasteUtil::create()
    ->setTables([
        'ek_shop_has_product_card',
        'ek_shop_has_product_card_lang',
    ]);
$util->renderColumns(['mode' => 'props']);
$util->renderConstructorDefaultValues();



```

Will display something like this in the browser:


```txt 

ek_shop_has_product_card

private $shop_id;
private $product_card_id;
private $product_id;
private $active;


ek_shop_has_product_card_lang


private $shop_id;
private $product_card_id;
private $lang_id;
private $label;
private $slug;
private $description;
private $meta_title;
private $meta_description;
private $meta_keywords;

Constructor

$this->shop_id = 0;
$this->product_card_id = 0;
$this->product_id = 0;
$this->active = 0;
$this->shop_id = 0;
$this->product_card_id = 0;
$this->lang_id = 0;
$this->label = '';
$this->slug = '';
$this->description = '';
$this->meta_title = '';
$this->meta_description = '';
$this->meta_keywords = '';
```



History Log
------------------
    
- 1.0.0 -- 2017-08-30

    - initial commit