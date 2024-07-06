<?php

declare(strict_types=1);

namespace Shimmie2;

use function MicroHTML\SCRIPT;

class GoogleAnalytics extends Extension
{
    # Add analytics to config
    public function onSetupBuilding(SetupBuildingEvent $event): void
    {
        $sb = $event->panel->create_new_block("Google Analytics");
        $sb->add_text_option("google_analytics_id", "Analytics ID: ");
        $sb->add_label("<br>(eg. G-xxxxxxxx)");
    }

    # Load Analytics tracking code on page request
    public function onPageRequest(PageRequestEvent $event): void
    {
        global $config, $page;

        $google_analytics_id = $config->get_string('google_analytics_id', '');
        if (stristr($google_analytics_id, "G-")) {
            $page->add_html_header("<script async src=\"https://www.googletagmanager.com/gtag/js?id=$google_analytics_id\"></script>
                                    <script>
                                      window.dataLayer = window.dataLayer || [];
                                      function gtag(){dataLayer.push(arguments);}
                                      gtag('js', new Date());
                                    
                                      gtag('config', '$google_analytics_id');
                                    </script>
                                    ");
        }
    }
}
