<?php

namespace IPVC;

require_once("product.php");
require_once("attribute.php");

class Worker
{
    const IMPORT_FILE = "import/products.xml";
    protected $file_path = '';
    public function __construct()
    {
        $wp_upload_dir = wp_get_upload_dir();
        if (
            !empty($wp_upload_dir['basedir'])
            && file_exists($file = trailingslashit($wp_upload_dir['basedir']) . self::IMPORT_FILE)
        ) {
            $xml = simplexml_load_file($file);
            if ($xml instanceof \SimpleXMLElement && $xml->getName() == 'products' && $xml->count() > 0) {
                $this->run($xml);
            }
        }
    }

    protected function run(\SimpleXMLElement $xml)
    {
        foreach ($xml->children() as $xml_product) {

            $product = new \IPVC\Product();
            if ($xml_product instanceof \SimpleXMLElement && $xml_product->getName() == 'product') {

                $this->get_product_attributes($xml_product, $product);
                $this->get_product_labels($xml_product, $product);

                $this->get_product_sizes($xml_product, $product);
                $this->get_product_colors($xml_product, $product);

                $this->get_product_skus($xml_product, $product);
            }

            $product->save();
        }
    }


    protected function get_product_attributes($xml_product, \IPVC\Product $product)
    {
        foreach ($xml_product->attributes() as $name => $value) {
            switch ($name) {
                case 'name':
                    $product->setTitle((string)$value);
                    break;
                case 'id':
                    $product->setSku((string)$value);
                    break;
                case 'description':
                    $product->setDescription((string)$value);
                    break;
                case 'white_price':
                    $product->setPrice((string)$value);
                    break;
                case 'light_price':
                    $product->setSale((string)$value);
                    break;
                default:
                    $product->setOther_meta((string)$value);
            }
        }
    }

    protected function get_product_labels(\SimpleXMLElement $xml_product, \IPVC\Product $product)
    {
        if (isset($xml_product->size_chart_labels) && count($xml_product->size_chart_labels) > 0) {
            foreach ($xml_product->size_chart_labels->children() as  $label) {
                if ($label->getName() == 'label' && isset($label->attributes()['name'])) {
                    $product->setTags((string)$label->attributes()['name']);
                }
            }
        }
    }
    protected function get_product_sizes(\SimpleXMLElement $xml_product, \IPVC\Product $product)
    {
        if (isset($xml_product->sizes) && count($xml_product->sizes) > 0) {
            foreach ($xml_product->sizes->children() as  $size) {

                if (
                    $size->getName() == 'size'
                    && !empty($id = (string)$size->attributes()['id'])
                    && !empty($name = (string)$size->attributes()['name'])
                ) {
                    $attribute = new  \IPVC\Attribute($name);
                    foreach ($size->attributes() as $key => $val) {
                        if (!in_array($key, ['id', 'name'])) {
                            $attribute->setMeta($key, (string)$val);
                        }
                    }
                    $product->setSizes($id, $attribute);
                }
            }
        }
    }
    protected function get_product_colors(\SimpleXMLElement $xml_product, \IPVC\Product $product)
    {
        if (isset($xml_product->colors) && count($xml_product->colors) > 0) {
            foreach ($xml_product->colors->children() as  $color) {

                if (
                    $color->getName() == 'color'
                    && isset($color->attributes()['id'])
                    && !empty($color_meta = $color->clr[0])
                    && !empty($name = (string)$color_meta->attributes()['name'])
                ) {
                    $attribute = new  \IPVC\Attribute($name);

                    if (!empty($html = (string)$color_meta->attributes()['html'])) {
                        $attribute->setMeta('html', $html);
                    }
                    $color_id = (string)$color->attributes()['id'];
                    $product->setColors($color_id, $attribute);
                }
            }
        }
    }
    protected function get_product_skus(\SimpleXMLElement $xml_product, \IPVC\Product $product)
    {
        if (isset($xml_product->skus) && count($xml_product->skus) > 0) {
            foreach ($xml_product->skus->children() as  $label) {
                if (
                    $label->getName() == 'sku'
                    && !empty($code = (string)$label->attributes()['code'])
                    && !empty($color_id = (string)$label->attributes()['color_id'])
                    && !empty($size_id = (string)$label->attributes()['size_id'])
                ) {
                    $product->setVariations($code, $color_id, $size_id);
                }
            }
        }
    }
}
