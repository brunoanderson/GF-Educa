<?php

use App\Models\LegacyDeficiency;

class Portabilis_View_Helper_Input_Resource_MultipleSearchDeficiencias extends Portabilis_View_Helper_Input_MultipleSearch
{
    protected function getOptions($resources)
    {
        if (empty($resources)) {
            $resources = LegacyDeficiency::orderBy('nm_deficiencia')->where('deficiency_type_id', 1)->pluck('nm_deficiencia', 'cod_deficiencia')->toArray();
        }

        return $this->insertOption(null, '', $resources);
    }

    public function multipleSearchDeficiencias($attrName, $options = [])
    {
        $defaultOptions = [
            'objectName' => 'deficiencias',
            'apiController' => 'Deficiencia',
            'apiResource' => 'deficiencia-search'
        ];

        $options = $this->mergeOptions($options, $defaultOptions);
        $options['options']['resources'] = $this->getOptions($options['options']['resources']);

        $this->placeholderJs($options);

        parent::multipleSearch($options['objectName'], $attrName, $options);
    }

    protected function placeholderJs($options)
    {
        $optionsVarName = 'multipleSearch' . Portabilis_String_Utils::camelize($options['objectName']) . 'Options';

        $js = "
            if (typeof $optionsVarName == 'undefined') { $optionsVarName = {} };
            $optionsVarName.placeholder = 'Selecione as deficiências';
        ";

        Portabilis_View_Helper_Application::embedJavascript($this->viewInstance, $js, $afterReady = true);
    }
}
