<?php
/**
 * WordPress için taban ayar dosyası.
 *
 * Bu dosya şu ayarları içerir: MySQL ayarları, tablo öneki,
 * gizli anahtaralr ve ABSPATH. Daha fazla bilgi için 
 * {@link https://codex.wordpress.org/Editing_wp-config.php wp-config.php düzenleme}
 * yardım sayfasına göz atabilirsiniz. MySQL ayarlarınızı servis sağlayıcınızdan edinebilirsiniz.
 *
 * Bu dosya kurulum sırasında wp-config.php dosyasının oluşturulabilmesi için
 * kullanılır. İsterseniz bu dosyayı kopyalayıp, ismini "wp-config.php" olarak değiştirip,
 * değerleri girerek de kullanabilirsiniz.
 *
 * @package WordPress
 */

// ** MySQL ayarları - Bu bilgileri sunucunuzdan alabilirsiniz ** //
/** WordPress için kullanılacak veritabanının adı */
define('DB_NAME', 'FishDB');

/** MySQL veritabanı kullanıcısı */
define('DB_USER', 'DBfish');

/** MySQL veritabanı parolası */
define('DB_PASSWORD', 'Db252536!');

/** MySQL sunucusu */
define('DB_HOST', '94.138.202.5');

/** Yaratılacak tablolar için veritabanı karakter seti. */
define('DB_CHARSET', 'utf8');

/** Veritabanı karşılaştırma tipi. Herhangi bir şüpheniz varsa bu değeri değiştirmeyin. */
define('DB_COLLATE', '');

/**#@+
 * Eşsiz doğrulama anahtarları.
 *
 * Her anahtar farklı bir karakter kümesi olmalı!
 * {@link http://api.wordpress.org/secret-key/1.1/salt WordPress.org secret-key service} servisini kullanarak yaratabilirsiniz.
 * Çerezleri geçersiz kılmak için istediğiniz zaman bu değerleri değiştirebilirsiniz. Bu tüm kullanıcıların tekrar giriş yapmasını gerektirecektir.
 *
 * @since 2.6.0
 */

define('FTP_USER', 'fishtp2008');
define('FTP_PASS', 'FishWebFish2015');
define('FTP_HOST', 'localhost');
define('FTP_SSL', false);

define('AUTH_KEY',         '/gI^+:2bb$M+f5}(uqvK~[ aH)@b0)#F`Uxn,;<9bXPanro@2z+(Sj4(2-GQF`Es');
define('SECURE_AUTH_KEY',  'sJ_@L|u)]{L]*v3$<eV:eF0Q7|fUy+0=+~l%bUZDtpf]kW.i[h_}p?17kYxNK34_');
define('LOGGED_IN_KEY',    ' M-X[bU .Bbh+zyAk`EaYxD<NXbMkh]cu&cy^}at;]K,MWPp0AsfYT$5Jbs@_|M1');
define('NONCE_KEY',        '63=PjR,a1-i+@V7c.;vwY;w-$-i.^.a;1kHP2TnJ`Yx+Znk%ut|$-}3^1+46W[,?');
define('AUTH_SALT',        'yiubZ%++!*zBpk1Kf@:dp+B4.?mY7#*pmRhkw.$z.N+Aq:RDWaY{*?,N%yn*|bA[');
define('SECURE_AUTH_SALT', 'ZhkLrcyh8eVMB9.P^oF:`Dy[+6/=i~o<)Au2UqeM-ou:`ks6oId|W9 z[$D)?o<O');
define('LOGGED_IN_SALT',   '6Had+=[Z:ux|N/N6ad5*|7*4Pom>yz+y >!$Pwm:(1|-/&l/J,NZRhTrs$~>},tZ');
define('NONCE_SALT',       'r}3aa2M!{]RqL}8IM9SVv-,~GeP,-z-Aov]+J^L=2.zI*qyn@=jYN8o!/LoV1{E5');
/**#@-*/

/**
 * WordPress veritabanı tablo ön eki.
 *
 * Tüm kurulumlara ayrı bir önek vererek bir veritabanına birden fazla kurulum yapabilirsiniz.
 * Sadece rakamlar, harfler ve alt çizgi lütfen.
 */
$table_prefix  = 'wp_';

/**
 * Geliştiriciler için: WordPress hata ayıklama modu.
 *
 * Bu değeri "true" yaparak geliştirme sırasında hataların ekrana basılmasını sağlayabilirsiniz.
 * Tema ve eklenti geliştiricilerinin geliştirme aşamasında WP_DEBUG
 * kullanmalarını önemle tavsiye ederiz.
 */
define('WP_DEBUG', false);

/* Hepsi bu kadar. Mutlu bloglamalar! */

/** WordPress dizini için mutlak yol. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** WordPress değişkenlerini ve yollarını kurar. */
require_once(ABSPATH . 'wp-settings.php');
