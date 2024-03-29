<?php

class Janrain_Engage_Block_Accountdata extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {

    public function render(Varien_Data_Form_Element_Abstract $element) {

        $html = $this->_getHeaderHtml($element);

        $html.= $this->_getFieldHtml($element);

        $html .= $this->_getFooterHtml($element);

        return $html;
    }

    protected function _getFieldHtml($fieldset) {
        $vars = array(
            'realm' => 'Realm',
            'realmscheme' => 'Realm Scheme',
            'appid' => 'App Id',
            'adminurl' => 'Admin URL',
            'socialpub' => 'Share Providers',
            'enabled_providers' => 'Authentication Providers'
        );

        if (Mage::helper('engage')->isEngageEnabled() === false)
            return '<p>Module not enabled. Please set "Enabled" to "Yes" and enter your API key above.</p>';

        $content = '<link type="text/css" href="' . Mage::helper('engage')->_baseSkin() . '/stylesheet.css" rel="stylesheet" />';
        $content .= '<p>The following is the current account info being used. <a href="' . Mage::helper('adminhtml')->getUrl('engageadmin/adminhtml_lookup/rp') . '">Click Here to refresh</a></p>';

        $content .= '<table><tbody>';
        foreach ($vars as $key => $val) {
            $value = Mage::getStoreConfig('engage/vars/' . $key);

            if ($value && ($key == 'socialpub' || $key == 'enabled_providers')) {
                $providers = explode(",", $value);
                $value = '<a class="rpx-icons" href="' . Mage::getStoreConfig('engage/vars/adminurl') . '" target="_blank">';
                foreach ($providers as $p) {
                    $value .= '<div class="janrain-provider-icon-16 janrain-provider-icon-'.$p.'" title="' . htmlentities($p) . '"></div>';
                }
                $value .= '</a>';
            }
            elseif ($key == 'adminurl')
                $value = '<a href="' . $value . '" target="_blank">' . $value . '</a>';

            $content .= '<tr><td><em>' . $val . ':</em></td><td>' . $value . '</td></tr>';
        }
        $content .= '</tbody></table>';

        return $content;
    }

}
