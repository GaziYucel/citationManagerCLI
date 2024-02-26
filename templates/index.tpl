{**
 * plugins/importexport/CitationManagerCLI/templates/index.tpl
 *
 * @copyright (c) 2021+ TIB Hannover
 * @copyright (c) 2021+ Gazi Yücel
 * @license Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * List of operations this plugin can perform
 *}
{extends file="layouts/backend.tpl"}

{block name="page"}
    <h1 class="app__pageHeading">
        {translate key="plugins.importexport.citationManagerCLI.displayName"}
    </h1>
    <div class="app__contentPanel">
        <div class="content">
            {$descriptionExtendedHtml}
        </div>
    </div>
{/block}
