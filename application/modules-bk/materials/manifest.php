<?php
$routes[] = ['GET|POST', '/admin/materials/form/[:slug]?/[i:copy]?', 'GoCart\Controller\AdminMaterials#form'];
$routes[] = ['GET|POST', '/admin/materials/gift-card-form/[i:id]?/[i:copy]?', 'GoCart\Controller\AdminMaterials#giftCardForm'];
$routes[] = ['GET|POST', '/admin/materials/delete/[:slug]/[i:id]', 'GoCart\Controller\AdminMaterials#delete'];
$routes[] = ['GET|POST', '/admin/materials/[:slug]?/[:order_by]?/[:sort_order]?/[:code]?/[i:page]?', 'GoCart\Controller\AdminMaterials#index'];
$routes[] = ['GET|POST', '/product/documents/[:slug]', 'GoCart\Controller\Product#documents'];
$routes[] = ['GET|POST', '/product/generator/[:slug]', 'GoCart\Controller\Product#generator'];
$routes[] = ['GET|POST', '/product/compare/[:slug]', 'GoCart\Controller\Product#compare'];
$routes[] = ['GET|POST', '/product/add_compare/[:slug]', 'GoCart\Controller\Product#add_compare'];
$routes[] = ['GET|POST', '/product/remove_compare/[:slug]', 'GoCart\Controller\Product#remove_compare'];
$routes[] = ['GET|POST', '/product/contact/[:slug]', 'GoCart\Controller\Product#contact'];
$routes[] = ['GET|POST', '/product/[:slug]', 'GoCart\Controller\Product#index'];
