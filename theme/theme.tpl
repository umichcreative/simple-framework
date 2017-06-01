<!doctype html>
<!--[if lte IE 8]><html class="no-js lte-ie8" lang="en"><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <? foreach( self::$_meta as $type => $content ): ?>
    <meta name="<?=$type;?>" content="<?=htmlentities( $content, ENT_QUOTES, 'UTF-8' );?>" />
    <? endforeach; ?>

    <title><?=self::setVar( 'pageTitle' );?></title>

    <link rel="stylesheet" href="<?=SFW_BASE;?>framework/theme/vendor/foundation-6.2.3/<?=self::setVar( 'siteGrid' ) ?: 12;?>col/foundation.min.css" />
    <link rel="stylesheet" href="<?=SFW_BASE;?>framework/theme/vendor/font-awesome-4.7.0/css/font-awesome.min.css" />
<? foreach( self::$_styles as $style ): ?>
    <link rel="stylesheet" href="<?=$style;?>" type="text/css"<?=( strpos( $style, '_print' ) ? ' media="print"' : null);?> />
<? endforeach; ?>
    <!--[if lt IE 9]>
        <link rel="stylesheet" href="<?=SFW_BASE;?>framework/theme/vendor/foundation-ie8/<?=self::setVar( 'siteGrid' ) ?: 12;?>col.css" />
        <link rel="stylesheet" href="<?=SFW_BASE;?>framework/theme/vendor/styles/ie8/base.css" />
    <![endif]-->

    <? self::render( 'head.tpl' ); ?> 
</head>
<body class="sfwGrid-<?=self::setVar( 'siteGrid' ) ?: 12;?><?=(self::setVar( 'siteBodyClass' ) ?: null);?>">
<!--{CONTENTS}-->

<script type="text/javascript" src="<?=SFW_BASE;?>framework/theme/vendor/scripts/rem.js"></script>
<script type="text/javascript" src="<?=SFW_BASE;?>framework/theme/vendor/scripts/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="<?=SFW_BASE;?>framework/theme/vendor/scripts/jquery-migrate-1.4.1.min.js"></script>
<? foreach( self::$_scripts as $script ): ?>
<script type="text/javascript" src="<?=$script;?>"></script>
<? endforeach; ?>
</body>
</html>
