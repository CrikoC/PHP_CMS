<?php
function redirect_to( $location = NULL ) {
    if ($location != NULL) {
        ?> <script>
            window.location = '<?php echo $location; ?>';
        </script>
        <?php
        exit;
    }
}

function output_message($message) {
    if (!empty($message)) {
        return $message;
    } else {
        return "";
    }
}

function the_excerpt($content) {
    echo substr($content,0,100);
}

function section($template="") {
    include(SITE_ROOT.DS.'public'.DS.'includes'.DS.'partials'.DS.$template);
}

function admin_section($template="") {
    include(SITE_ROOT.DS.'public'.DS.'admin'.DS.'includes'.DS.'partials'.DS.$template);
}

function is_method($method=null) {
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    } else {
        return false;
    }
}

function log_action($action, $message="") {
    $logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
    $new = file_exists($logfile) ? false : true;
    if($handle=fopen($logfile,'a')) {
        $timestamp = strftime('%Y-%m-%d %H:%M:%S', time());
        $content = $timestamp | $action .": " . $message . "\n";
        fwrite($handle, $content);
        fclose($handle);
        if($new) {
            chmod($logfile, 0755);
        }
    }
    else {
        echo "Could not open log file for writing";
    }

    function datetime_to_text($datetime="") {
        $unixdatetime = strtotime($datetime);
        return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
    }
}