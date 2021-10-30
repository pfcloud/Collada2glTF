<?php
  //////////////////////////////////////////////
  /**
   * A web proxy that converts Collada (.dae extension file) to glTF format file.
   */
  //////////////////////////////////////////////

  /////////////////////////////////////
  define("COLLADA_DIR" , "/var/www/data/c2g.php/collada");
  define("GLTF_DIR"    , "/var/www/data/c2g.php/collada/output");
  define("VALID_DOMAIN", "https://");

  /////////////////////////////////////
  $url = $_GET['u'];
  if(
    (isset($url) == false)or
    ($url == "")or
    (strpos($url, '.dae') === false)or
    (strpos($url, VALID_DOMAIN) === false)
  ){
    return;
  }

  //////////////////////////////////////////////
  $refresh = $_GET['refresh'];
  if(isset($refresh) == true && $refresh = 1)
  {
    $force_refresh = true;
  }
  
  /////////////////////////////////////
  $collada_filename_sha1 = basename($url) . "_" . sha1($url);
  $gtlf_filename_sha1 = str_replace('.dae', '.gltf', $collada_filename_sha1);
  $gltf_filename = substr($gtlf_filename_sha1 ,0 ,strlen($gtlf_filename_sha1) - 41);

  /////////////////////////////////////
  if (file_exists(GLTF_DIR . "/" . $gtlf_filename_sha1) && !$force_refresh) {
    header('Content-Type: model/gltf+json');
    header("Content-Disposition: attachment; filename=$gltf_filename"); 
    readfile(GLTF_DIR . "/" . $gtlf_filename_sha1);
    return;
  }

  /////////////////////////////////////
  $collada_data = file_get_contents($url);
  file_put_contents(COLLADA_DIR."/".$collada_filename_sha1, $collada_data);

  /////////////////////////////////////
  $cmd = "/home/ec2-user/COLLADA2GLTF/build/COLLADA2GLTF-bin"
  . " -i " . COLLADA_DIR . "/" . $collada_filename_sha1
  . " -o " . GLTF_DIR . "/" . $gtlf_filename_sha1;
  exec($cmd, $output);

  /////////////////////////////////////
  header('Content-Type: model/gltf+json');
  header("Content-Disposition: attachment; filename=$gltf_filename"); 
  readfile(GLTF_DIR . "/" . $gtlf_filename_sha1);
  return;
