<?php 
function link_to_frontend($name, $parameters, $popup = true)
{
  return sfProjectConfiguration::getActive()->generateFrontendUrl($name, $parameters, $popup);
}