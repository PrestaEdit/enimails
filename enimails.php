<?php

use PrestaShop\PrestaShop\Core\MailTemplate\Layout\Layout;
use PrestaShop\PrestaShop\Core\MailTemplate\ThemeCatalogInterface;
use PrestaShop\PrestaShop\Core\MailTemplate\ThemeCollectionInterface;
use PrestaShop\PrestaShop\Core\MailTemplate\ThemeInterface;

class EniMails extends Module
{
    public function __construct()
    {
        $this->name = 'enimails';

        parent::__construct();
    }

    public function install()
    {
        return parent::install()
            // 'actionListMailThemes'
            && $this->registerHook(ThemeCatalogInterface::LIST_MAIL_THEMES_HOOK)
        ;
    }

    /**
     * @param array $hookParams
     */
    public function hookActionListMailThemes(array $hookParams)
    {
        dump('e');
        if (!isset($hookParams['mailThemes'])) {
            return;
        }

        /** @var ThemeCollectionInterface $themes */
        $themes = $hookParams['mailThemes'];

        /** @var ThemeInterface $theme */
        foreach ($themes as $theme) {
            // Vérification du nom du thème
            if (!in_array($theme->getName(), ['classic', 'modern'])) {
                continue;
            }

            // Ajout du template
            $theme->getLayouts()->add(new Layout(
                'module_layout',
                __DIR__ . '/mails/layouts/module_layout.html.twig',
                '',
                $this->name
            ));
        }
    }
}
