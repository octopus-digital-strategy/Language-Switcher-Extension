<?php


namespace LanguageSwitcherExtension;


class Translations
{

    private $translations;
    private $transientID;

    public function __construct()
    {
        $this->setTranslations();
        $this->transientID = "__lsex_translation_menu_items";
    }

    private function getSiteByLanguage( $language )
    {
        $sites = \MslsBlogCollection::instance()->get();
        foreach( $sites as $id => $s ) {
            if( $language == $s->get_language() ) {
                return $sites[$id];
            }
        }
        return false;
    }

    private function setTranslations()
    {
        global $post;

        $pageID = empty( $post ) ? 'home' : "pageID_{$post->ID}";

        $transientValue = get_transient($this->transientID);
        if( false !== $transientValue && isset( $transientValue[$pageID] ) ) {
            $this->translations = $transientValue[$pageID];
            return $transientValue;
        }

        $list  = array();
        $blogs = \MslsBlogCollection::instance()->get_filtered();
        if( $blogs ) {
            $mydata = \MslsOptions::create();
            $link   = \MslsLink::create(0);

            foreach( $blogs as $blog ) {
                $language = $blog->get_language();
                $url      = $mydata->get_current_link();
                $current  = ( $blog->userblog_id == \MslsBlogCollection::instance()->get_current_blog_id() );

                if( $current ) {
                    $link->txt = $blog->get_description();
                } else {
                    switch_to_blog($blog->userblog_id);

                    if( \MslsOutput::init()->is_requirements_not_fulfilled($mydata, false, $language) ) {
                        restore_current_blog();
                        continue;
                    } else {
                        $url       = $mydata->get_permalink($language);
                        $link->txt = $blog->get_description();
                    }

                    restore_current_blog();
                }

                $link->src = \MslsOptions::instance()->get_flag_url($language);
                $link->alt = $language;

                $itemArray = $link->get_arr();
                $linkText  = $this->getLanguageTranslation($itemArray['txt']);

                $list[$language] = array(
                    'url'      => $url,
                    'flagURL'  => $itemArray['src'],
                    'flag'     => "<img src=\"{$itemArray['src']}\" alt=\"{$linkText}\"/>",
                    'htmlLink' => "<a href=\"{$url}\" class=\"translationLink\"><img src=\"{$itemArray['src']}\" alt=\"{$linkText}\"> {$linkText}</a>",
                    'linkText' => $linkText,
                );
            }

            // Set the transient value
            if( !empty( $transientValue ) ) {
                $transientValue = array_merge(array( "{$pageID}" => $list ), $transientValue);
            } else {
                $transientValue = array( "{$pageID}" => $list );
            }
            set_transient($this->transientID, $transientValue, 600); // 10minutes should do it!
        }

        $this->translations = $list;

        return $list;
    }

    public function getTranslations( $targetLanguage = '' )
    {
        if( empty( $targetLanguage ) ) {
            return empty( $this->translations ) ? array() : $this->translations;
        }
        return isset( $this->translations[$targetLanguage] ) ? $this->translations[$targetLanguage] : array();
    }
    
    public static function getLanguageTranslation( $languageKey )
    {
        if( $languageKey == 'es' ) {
            $languageKey = 'es_MX';
        }

        switch( strtolower($languageKey) ) {
            case "es_mx":
                $translation = __('es_MX', 'lsex');
                break;
            case "es_es":
                $translation = __('es_ES', 'lsex');
                break;
            case "fr_fr":
                $translation = __('fr_FR', 'lsex');
                break;
            case "en_en":
                $translation = __('en_EN', 'lsex');
                break;
            default:
                $translation = __('en_US', 'lsex');
        }

        return $translation;
    }

}