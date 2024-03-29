<?php
/**
 * @file CitationManagerCLIPlugin.php
 *
 * @copyright (c) 2021+ TIB Hannover
 * @copyright (c) 2021+ Gazi Yücel
 * @license Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class CitationManagerCLIPlugin
 * @brief CLI Plugin for CitationManagerPlugin.
 */

import('lib.pkp.classes.plugins.ImportExportPlugin');

class CitationManagerCLIPlugin extends ImportExportPlugin
{
    public string $citationManagerPluginName = 'citationmanagerplugin';

    /** @copydoc ImportExportPlugin::register() */
    public function register($category, $path, $mainContextId = null): bool
    {
        $success = parent::register($category, $path, $mainContextId);

        if ($success && $this->getEnabled()) {
            $this->addLocaleData();
        }

        return $success;
    }

    /** @copydoc ImportExportPlugin::display() */
    public function display($args, $request): void
    {
        parent::display($args, $request);

        $templateManager = TemplateManager::getManager();
        $templateManager->assign([
            'descriptionExtendedHtml'
            => __('plugins.importexport.citationManagerCLI.descriptionExtendedHtml',
                ['pluginName' => $this->getName()])]);
        $templateManager->display($this->getTemplateResource('index.tpl'));
    }

    /** @copydoc ImportExportPlugin::executeCLI() */
    public function executeCLI($scriptName, &$args): void
    {
        $command = array_shift($args);
        $isCitationManagerPluginInstalled = $this->isCitationManagerPluginInstalled();

        // check if all requirements met
        if (!$command || !$isCitationManagerPluginInstalled) {
            echo __('plugins.importexport.CitationManagerCLIPlugin.cliError') . "\n";

            if (!$isCitationManagerPluginInstalled)
                echo __('plugins.importexport.CitationManagerCLIPlugin.notInstalled') . "\n";

            $this->usage($scriptName);

            return;
        }

        switch ($command) {
            case 'inbound':
                $inbound = new \APP\plugins\generic\citationManager\classes\Handlers\InboundHandler();
                $inbound->batchExecute();
                return;
            case 'outbound':
                $outbound = new \APP\plugins\generic\citationManager\classes\Handlers\OutboundHandler();
                $outbound->batchExecute();
                return;
        }

        $this->usage($scriptName);
    }

    /**
     * Checks whether the Citation Manager Plugin is installed.
     *
     * @return bool
     */
    public function isCitationManagerPluginInstalled(): bool
    {
        $plugin = PluginRegistry::getPlugin('generic', $this->citationManagerPluginName);

        if ($plugin) return true;

        return false;
    }

    /** @copydoc ImportExportPlugin::usage() */
    public function usage($scriptName): void
    {
        echo __('plugins.importexport.citationManagerCLI.cliUsage', array(
                'scriptName' => $scriptName,
                'pluginName' => $this->getName()
            )) . "\n";
    }

    /** @copydoc ImportExportPlugin::getDisplayName() */
    function getDisplayName(): string
    {
        return __('plugins.importexport.citationManagerCLI.displayName');
    }

    /** @copydoc ImportExportPlugin::getDescription() */
    function getDescription(): string
    {
        return __('plugins.importexport.citationManagerCLI.description');
    }

    /** @copydoc ImportExportPlugin::getName() */
    public function getName(): string
    {
        $class = explode('\\', __CLASS__);
        return array_pop($class);
    }
}
