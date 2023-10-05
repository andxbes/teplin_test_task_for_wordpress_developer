<?php

namespace IPVC;

class Product
{
    private
        $sku,
        $title,
        $description,
        $price,
        $sale,
        $other_meta = [],
        $images = [],
        $cats = [],
        $tags = [],
        $colors = [],
        $sizes = [],
        $variations = [];


    /**
     * @param mixed $title 
     * @return self
     */
    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param mixed $description 
     * @return self
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param mixed $price 
     * @return self
     */
    public function setPrice($price): self
    {
        $this->price = floatval($price);
        return $this;
    }

    /**
     * @param mixed $sale 
     * @return self
     */
    public function setSale($sale): self
    {
        $this->sale = floatval($sale);
        return $this;
    }

    /**
     * @param mixed $other_meta 
     * @return self
     */
    public function setOther_meta($other_meta): self
    {
        $this->other_meta[] = $other_meta;
        return $this;
    }

    /**
     * @param mixed $images 
     * @return self
     */
    public function setImages($image): self
    {
        $this->images[] = $image;
        return $this;
    }

    /**
     * @param mixed $cats 
     * @return self
     */
    public function setCats($cats): self
    {
        $this->cats = $cats;
        return $this;
    }

    /**
     * @param mixed $tags 
     * @return self
     */
    public function setTags($tag): self
    {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * @param mixed $colors 
     * @return self
     */
    public function setColors($id, $color): self
    {
        $this->colors[$id] = $color;
        return $this;
    }

    /**
     * @param mixed $sizes 
     * @return self
     */
    public function setSizes($id, $size): self
    {
        $this->sizes[$id] = $size;
        return $this;
    }

    /**
     * @param mixed $variations 
     * @return self
     */
    public function setVariations($sku, $color_id, $size_id): self
    {
        if (
            !empty($color =  $this->colors[$color_id])
            &&  !empty($size = $this->sizes[$size_id])
            && $color instanceof \IPVC\Attribute
            && $size instanceof \IPVC\Attribute
        ) {
            $price = floatval($size->getMeta('white_price'));
            $sale = floatval($size->getMeta('light_price'));

            $variation = [
                'sku' => $sku,
                'color' => $color->getName(),
                'size' => $size->getName(),
                'price' => !empty($price) ? $price : $this->price,
                'sale' => !empty($sale) ? $sale : $this->sale
            ];
            $this->variations[] = $variation;
        }

        return $this;
    }

    /**
     * Set the value of sku
     *
     * @return  self
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    public function save()
    {
        if (function_exists('WC')) {
            if (!empty($product_id =  wc_get_product_id_by_sku($this->sku))) {
                $product = wc_get_product($product_id);
            } else {
                $product = new \WC_Product_Variable();
                $product->set_sku($this->sku);
            }
            $product->set_name($this->title);

            $product->set_description($this->description);
            $product->set_regular_price($this->price);

            $attributes = [];
            if (!empty($this->colors)) {
                $attributes[] = $this->get_attribute('color', $this->colors);
            }
            if (!empty($this->sizes)) {
                $attributes[] = $this->get_attribute('size', $this->sizes);
            }
            $product->set_attributes($attributes);

            $product->save();
        }
    }

    protected function get_attribute($name, $attribute_values)
    {

        $values = array_column($attribute_values, 'name');

        $attribute_id = wc_attribute_taxonomy_id_by_name($name);

        if (!$attribute_id) {
            $attribute_id = wc_create_attribute(array(
                'name' => $name,
                'slug' => sanitize_title($name),
                'type' => 'select', // или 'text' в зависимости от типа атрибута
                'order_by' => 'menu_order',
                'has_archives' => true,
            ));
        }
        // foreach ($values as $val) {

        //     $insert_res = wp_insert_term(
        //         $val,
        //         'pa_' . $name,
        //     );
        // }


        $attribute = new \WC_Product_Attribute();

        $attribute->set_id($attribute_id);

        $attribute->set_name('pa_' . $name);
        $attribute->set_options($values);
        $attribute->set_position(1);
        $attribute->set_visible(true);
        $attribute->set_variation(true);
        return $attribute;
    }
}
