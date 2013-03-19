<script type="text/javascript">

//<![CDATA[
var flashvars = {
        /*
                IMPORTANT: when only using one of the options below, REMOVE THE COMMA (,) at the end of the line.
                                        Otherwise this will break JavaScript (and thus the loading of the Flash content) in Internet Explorer.
                                        (Just make sure that the last of the enabled settings does not end with a comma).

                Remove the // in front of an option to enable it.
        */

        /* This is the ABSOLUTE base that to use for all path resolving. This has an effect on ALL paths (including GUI, sounds etc). */
        //basePath: "template/js/flipPage/",

        /* Used to pass the name of the xml file to use. Path is RELATIVE to basePath, or, if not set, to the megazine.swf file. */
        //xmlFile: "megazine.mz3"

        /* When set to true, log messages are printed to the JavaScript console (using the console.log() function) */
        //logToJsConsole: "true"
};
var params = {
        /* Determines whether to enable transparency (show HTML background). Not recommended (slow). Use book/background instead. */
        //wmode: "transparent",
        menu: "false",
        /* Necessary for proper scaling of the content. */
        scale: "noScale",
        /* Necessary for fullscreen mode. */
        allowFullscreen: "true",
        /* Necessary for SWFAddress and other JavaScript interaction. */
        allowScriptAccess: "always",
        /* This is the background color used for the Flash element. */
        bgcolor: "#333333",
        /* Faz com que o objeto flash fique atras dos objetos html */
        wmode: "transparent"
};
var attributes = {
        /* This must be the same as the ID of the HTML element that will contain the Flash element. */
        id: "megazine"
};
/* Actually load the Flash. */
swfobject.embedSWF("template/js/flipPage/megazine/preloader.swf", "megazine", "100%", "600", "9.0.115", "template/js/flipPage/js/expressInstall.swf", flashvars, params, attributes);
//]]>
</script>
<div id="megazine" style="position: relative;">
</div>
