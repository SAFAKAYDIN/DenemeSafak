<?php
ZN\Inclusion\Style::use('bootstrap', 'awesome', 'external-template-style'); 
ZN\Inclusion\Script::use('jquery', 'bootstrap');
ZN\Inclusion\Template::use('ExternalTemplateStyles');

unset($trace['params']);
?>

<div class="col-lg-12" style="z-index:1000000; margin-top:15px">
    <div class="panel panel-default panel-top-header">

        <div class="panel-heading" style="background:#222; border:none;">
            <h3 class="panel-title panel-text h-panel-header">
            <i class="fa fa-exclamation-triangle fa-fw"></i> 
            <?php echo '<span class="text-color">'.($type ?? 'ERROR').'</span> &raquo; ' ?>
            <?php echo $message ?? NULL; ?></h3>
        </div>

        <div class="panel-body" style="margin-bottom:-17px;">
            <div class="list-group">
                <?php
                ZN\ErrorHandling\Exceptions::display($file, $line, NULL);
            
                foreach( $trace as $key => $debug )
                    if
                    ( 
                        ! empty($debug['file'])                  &&
                        ! strstr($debug['file'], 'zeroneed.php') &&
                        ! strstr($debug['file'], 'zerocore.php') &&
                        ! strstr($debug['file'], 'Facade.php')   &&
                        ! strstr($debug['file'], 'ZN.php')       &&
                        $debug['file'] !== $file                         
                    )
                    ZN\ErrorHandling\Exceptions::display($debug['file'], $debug['line'], $key);
                ?>
            </div>
        </div>
    </div>
</div>