<?php

namespace App\Http\Controllers\Admin\Traits;

use App\Models\Variation;
use Illuminate\Support\Str;

trait ProductTrait {
	public function prepareData ($requestAll) {
        $data['name'] = $requestAll['name'];
        $data['slug'] = Str::slug($requestAll['name']);
        $data['sku'] = $requestAll['sku'];
        $data['quantity'] = $requestAll['quantity'];
        $data['short_description'] = $requestAll['short_description'];
        $data['price'] = $requestAll['price'];
        $data['discount'] = $requestAll['discount'] ?? '';
        $data['discount_price'] = ($requestAll['price'] * (100 - $requestAll['discount'])) / 100;
        $data['date_discount_period'] = $requestAll['date_discount_period'] ?? '';
        $data['is_variation'] = $requestAll['is_variation'] ?? 0;
        $data['low_stock_to_notify'] = $requestAll['low_stock_to_notify'] ?? 100;
        $data['status'] = $requestAll['status'];
        $data['photo'] = $requestAll['photo'] ?? '';
        $data['description'] = $requestAll['description'] ?? '';
        $data['featured_product'] = $requestAll['featured_product'] ?? 0;
        $data['new_arrival'] = $requestAll['new_arrival'] ?? 0;
        $data['on_sale'] = $requestAll['on_sale'] ?? 0;
        $data['brand_id'] = $requestAll['brand'] ?? '';
        $data['meta_title'] = $requestAll['meta_title'] ?? '';
        $data['meta_description'] = $requestAll['meta_description'] ?? '';
        $data['display_order'] = $requestAll['display_order'] ?? 1;
        $data['categories'] = $requestAll['categories'] ?? [];
        
        // Xử lý galleries - có thể là string phân cách bằng dấu phẩy hoặc array
        $galleries = $requestAll['galleries'] ?? '';
        if (is_string($galleries)) {
            $data['galleries'] = array_filter(array_map('trim', explode(',', $galleries)));
        } else {
            $data['galleries'] = is_array($galleries) ? $galleries : [];
        }
        
        $data['tags'] = $requestAll['tags'] ?? [];
        $data['variations'] = $this->prepareVariationsData($requestAll['variations'] ?? []);
        return $data;
    }

    private function prepareVariationsData ($paramVariations) {
        $productVariations = [];
        if (!empty($paramVariations)) {
            foreach ($paramVariations as $keyVar => $paramVariation) {
                // Kiểm tra cấu trúc mới (từ giao diện đơn giản)
                if (isset($paramVariation['attribute_id']) && isset($paramVariation['attribute_value_id'])) {
                    $productVariations[$keyVar]['id'] = $paramVariation['id'] ?? '';
                    $productVariations[$keyVar]['sku'] = $paramVariation['sku'] ?? '';
                    $productVariations[$keyVar]['price'] = $paramVariation['price'] ?? 0;
                    $productVariations[$keyVar]['quantity'] = $paramVariation['quantity'] ?? 0;
                    $productVariations[$keyVar]['is_default'] = 0;
                    
                    // Tạo meta cho cấu trúc mới
                    $objMeta = [];
                    $objMeta[$paramVariation['attribute_id']][] = [
                        'id' => $paramVariation['attribute_value_id'],
                        'name' => $paramVariation['value_name'],
                        'product_attribute_name' => $paramVariation['attribute_name']
                    ];
                    $productVariations[$keyVar]['meta'] = json_encode($objMeta);
                }
                // Xử lý cấu trúc cũ (backward compatibility)
                else {
                    $productAttributes = [];
                    if (!empty($paramVariation['attribute_ids']) && !empty($paramVariation['attribute_names'])) {
                        $productAttributes = array_combine($paramVariation['attribute_ids'], $paramVariation['attribute_names']);
                    }
                    if (!empty($paramVariation['product_attribute_values']) && !empty($productAttributes)) {
                        $productVariations[$keyVar]['id'] = $paramVariation['id'] ?? '';
                        $productVariations[$keyVar]['sku'] = $paramVariation['sku'] ?? '';
                        $productVariations[$keyVar]['price'] = $paramVariation['price'] ?? 0;
                        $productVariations[$keyVar]['quantity'] = $paramVariation['quantity'] ?? '';
                        $productVariations[$keyVar]['is_default'] = $paramVariation['is_default'] ?? 0;

                        // handle data to meta
                        $objMeta = [];
                        if (!empty($productAttributes)) {
                            foreach ($productAttributes as $keyAttr => $productAttribute) {
                                foreach ($paramVariation['product_attribute_values'][$keyAttr] as $keyAttrVal => $productAttributeVal) {
                                    $dataAttrValues = explode('__', $productAttributeVal);
                                    $dataMeta['id'] = $dataAttrValues[0];
                                    $dataMeta['name'] = $dataAttrValues[1];
                                    $dataMeta['product_attribute_name'] = $productAttribute;
                                    $objMeta[$keyAttr][] = $dataMeta;
                                }
                            }
                        }
                        $productVariations[$keyVar]['meta'] = json_encode($objMeta);
                    }
                }
            }
        }
        return $productVariations;
    }

    public function prepareMetaForUpdate ($objMeta) {
        $arrAttr = [];
        $objMeta = json_decode($objMeta);
        if (!empty($objMeta)) {
            foreach ($objMeta as $keyItem => $item) {
                if (!empty($item)) {
                    foreach ($item as $item2) {
                        $arrAttr[$keyItem][] = $item2->id;
                    }
                }
            }
        }
        return $arrAttr;
    }

    public function handleVariationAction ($paramsVariations, $productId) {
        $dateNow = date('Y-m-d H:i:s');
	    $arrVariationIds = array_filter(array_column($paramsVariations, 'id'), 'trim');

	    // remove items was deleted
        Variation::where('product_id', $productId)->whereNotIn('id', $arrVariationIds)->delete();

	    // update items was change
        $arrVariationDataUpdates = array_filter($paramsVariations, function ($item) {
            return !empty($item['id']);
        });
        if (!empty($arrVariationDataUpdates)) {
            foreach ($arrVariationDataUpdates as $variation) {
                $variation['updated_at'] = $dateNow;
                Variation::where('product_id', $productId)->where('id',  $variation['id'])->update($variation);
            }
        }

	    // insert new items
        $arrVariationDataInserts = array_filter($paramsVariations, function ($item) {
            return empty($item['id']);
        });
        if (!empty($arrVariationDataInserts)) {
            foreach ($arrVariationDataInserts as &$variation) {
                unset($variation['id']);
                $variation['product_id'] = $productId;
                $variation['created_at'] = $dateNow;
                $variation['updated_at'] = $dateNow;
            }
            Variation::insert($arrVariationDataInserts);
        }
    }
}
