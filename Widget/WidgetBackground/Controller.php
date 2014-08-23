<?php
/**
 * @package ImpressPages
 *
 */
namespace Plugin\WidgetBackground\Widget\WidgetBackground;


class Controller extends \Ip\WidgetController
{

    public function getTitle()
    {
        return __('Background', 'Ip-admin', false);
    }

    public function generateHtml($revisionId, $widgetId, $data, $skin)
    {
        if (!isset($data['block']) || empty($data['block']))
        $data['block'] = ipBlock('bg_block'.$widgetId.'_')->exampleContent('')->render($revisionId);
        return parent::generateHtml($revisionId, $widgetId, $data, $skin);
    }

    public function duplicate($oldId, $newId, $data)
    {
        $newRevisionId = ipDb()->selectValue('widget', 'revisionId', array('id' => $newId));
        $widgetTable = ipTable('widget');
        $sql = "
            UPDATE
                $widgetTable
            SET
                `blockName` = REPLACE(`blockName`, 'bg_block" . (int)$oldId . "_', 'bg_block" . (int)$newId . "_')
            WHERE
                `revisionId` = :newRevisionId
            ";
        ipDb()->execute($sql, array('newRevisionId' => $newRevisionId));

        return $data;
    }

    public function getCssClasses(){
        return 'ipNoColumns ipHasInsideColumns';
    }
}
