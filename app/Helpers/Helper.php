<?php

namespace App\Helpers;

class Helper
{
    /**
     * Update page configuration
     *
     * @param array $pageConfigs
     * @return void
     */
    public static function updatePageConfig($pageConfigs)
    {
        $config = [];
        
        if (isset($pageConfigs)) {
            foreach ($pageConfigs as $config_key => $config_value) {
                config(['custom_config.' . $config_key => $config_value]);
            }
        }
    }

    /**
     * Get app brand logo SVG
     *
     * @return string
     */
    public static function getAppBrandLogo()
    {
        return '<svg width="30" height="24" viewBox="0 0 250 196" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M40.7849 196C63.2628 196 81.5698 177.693 81.5698 155.215C81.5698 132.737 63.2628 114.43 40.7849 114.43C18.307 114.43 0 132.737 0 155.215C0 177.693 18.307 196 40.7849 196Z" fill="#7367F0"></path>
            <path opacity="0.08" fill-rule="evenodd" clip-rule="evenodd" d="M41.5125 196C63.9904 196 82.2974 177.693 82.2974 155.215C82.2974 132.737 63.9904 114.43 41.5125 114.43C19.0345 114.43 0.727539 132.737 0.727539 155.215C0.727539 177.693 19.0345 196 41.5125 196Z" fill="url(#paint0_linear_2989_100980)"></path>
            <path opacity="0.08" fill-rule="evenodd" clip-rule="evenodd" d="M209.215 151C231.693 151 250 132.693 250 110.215C250 87.7372 231.693 69.4302 209.215 69.4302C186.737 69.4302 168.43 87.7372 168.43 110.215C168.43 132.693 186.737 151 209.215 151Z" fill="url(#paint1_linear_2989_100980)"></path>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M209.215 155C233.921 155 254 134.921 254 110.215C254 85.5088 233.921 65.4302 209.215 65.4302C184.509 65.4302 164.43 85.5088 164.43 110.215C164.43 134.921 184.509 155 209.215 155Z" fill="#7367F0"></path>
            <defs>
            <linearGradient id="paint0_linear_2989_100980" x1="0.727539" y1="155.215" x2="82.2974" y2="155.215" gradientUnits="userSpaceOnUse">
            <stop stop-color="#7367F0" stop-opacity="1"></stop>
            <stop offset="1" stop-color="#7367F0" stop-opacity="0"></stop>
            </linearGradient>
            <linearGradient id="paint1_linear_2989_100980" x1="168.43" y1="110.215" x2="250" y2="110.215" gradientUnits="userSpaceOnUse">
            <stop stop-color="#7367F0" stop-opacity="1"></stop>
            <stop offset="1" stop-color="#7367F0" stop-opacity="0"></stop>
            </linearGradient>
            </defs>
        </svg>';
    }
}
