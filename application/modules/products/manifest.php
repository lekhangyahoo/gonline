<?php

$routes[] = ['GET|POST', '/admin/products/product_autocomplete', 'GoCart\Controller\AdminProducts#product_autocomplete'];
$routes[] = ['GET|POST', '/admin/products/bulk_save', 'GoCart\Controller\AdminProducts#bulk_save'];
$routes[] = ['GET|POST', '/admin/products/product_image_form', 'GoCart\Controller\AdminProducts#product_image_form'];
$routes[] = ['GET|POST', '/admin/products/product_image_upload', 'GoCart\Controller\AdminProducts#product_image_upload'];
$routes[] = ['GET|POST', '/admin/products/delete_documents', 'GoCart\Controller\AdminProducts#delete_documents'];
$routes[] = ['GET|POST', '/admin/products/form/[i:id]?/[i:copy]?', 'GoCart\Controller\AdminProducts#form'];
$routes[] = ['GET|POST', '/admin/products/gift-card-form/[i:id]?/[i:copy]?', 'GoCart\Controller\AdminProducts#giftCardForm'];
$routes[] = ['GET|POST', '/admin/products/delete/[i:id]', 'GoCart\Controller\AdminProducts#delete'];
$routes[] = ['GET|POST', '/admin/products/[i:rows]?/[:order_by]?/[:sort_order]?/[:code]?/[i:page]?', 'GoCart\Controller\AdminProducts#index'];
$routes[] = ['GET|POST', '/product/documents/[:slug]', 'GoCart\Controller\Product#documents'];
$routes[] = ['GET|POST', '/product/generator/[:slug]', 'GoCart\Controller\Product#generator'];
$routes[] = ['GET|POST', '/product/compare/[:slug]', 'GoCart\Controller\Product#compare'];
$routes[] = ['GET|POST', '/product/add_compare/[:slug]', 'GoCart\Controller\Product#add_compare'];
$routes[] = ['GET|POST', '/product/remove_compare/[:slug]', 'GoCart\Controller\Product#remove_compare'];
$routes[] = ['GET|POST', '/product/contact/[:slug]', 'GoCart\Controller\Product#contact'];
$routes[] = ['GET|POST', '/product/calculate_setup/[:slug]', 'GoCart\Controller\Product#calculate_setup'];
$routes[] = ['GET|POST', '/product/[:slug]', 'GoCart\Controller\Product#index'];
