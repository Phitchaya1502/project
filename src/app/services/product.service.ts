import { Injectable, signal, computed } from '@angular/core';
import { Product, ProductCategoryType } from '../models/product.model';

@Injectable({
  providedIn: 'root'
})
export class ProductService {
  private readonly _products = signal<Product[]>([
    {
      id: 1,
      name: 'Mens Elite Tottenham Hotspur Away Shirt 2025/26',
      category: 'Men\'s Shirt',
      type: 'Men',
      price: 150.70,
      imageUrl: 'https://cdn11.bigcommerce.com/s-5e8c3uvulz/images/stencil/950w/products/30868/38920/xaviaway__26701.1756547611.jpg?c=1%201x,%20https://cdn11.bigcommerce.com/s-5e8c3uvulz/images/stencil/1900w/products/30868/38920/xaviaway__26701.1756547611.jpg?c=1%202x,%20https://cdn11.bigcommerce.com/s-5e8c3uvulz/images/stencil/2850w/products/30868/38920/xaviaway__26701.1756547611.jpg?c=1%203x',
      isNew: true
    },
    {
      id: 2,
      name: 'Liverpool FC 25/26 Home Jersey - Womens',
      category: 'Women\'s Shirt',
      type: 'Women',
      price: 130,
      salePrice: 84.99,
      imageUrl: 'https://assets.adidas.com/images/h_2000,f_auto,q_auto,fl_lossy,c_fill,g_auto/487c3e02dbb5467cacba194c1c44a8c6_9366/Liverpool_25-26_JV6435_41_detail.jpg',
    },
    {
      id: 3,
      name: 'Nike Phantom 6 Low Elite',
      category: 'Men\'s Soccer cleats for firm ground',
      type: 'Men',
      price: 186,
      imageUrl: 'https://static.nike.com/a/images/t_web_pdp_535_v2/f_auto/a0636d95-eab0-474b-8f11-056268003df6/PHANTOM+6+LOW+ELITE+LE+FG.png',
    },
    {
      id: 4,
      name: 'Nike Air Max Plus',
      category: 'Men\'s Soccer cleats for firm ground',
      type: 'Men',
      price: 114,
      imageUrl: 'https://static.nike.com/a/images/t_web_pdp_535_v2/f_auto/11001c40-42ab-46c7-a2c2-68af85c671f4/NIKE+AIR+MAX+PLUS.png',
    },
    {
      id: 5,
      name: 'Women’s Realmadrid Home Jersey White 25/26',
      category: 'Women\'s Shirt',
      type: 'Women',
      price: 150,
      imageUrl: 'https://shop.realmadrid.com/_next/image?url=https%3A%2F%2Flegends.broadleafcloud.com%2Fapi%2Fasset%2Fcontent%2FRMCFMZ0903_01.jpg%3FcontextRequest%3D%257B%2522forceCatalogForFetch%2522%3Afalse%2C%2522forceFilterByCatalogIncludeInheritance%2522%3Afalse%2C%2522forceFilterByCatalogExcludeInheritance%2522%3Afalse%2C%2522applicationId%2522%3A%252201H4RD9NXMKQBQ1WVKM1181VD8%2522%2C%2522tenantId%2522%3A%2522REAL_MADRID%2522%257D&w=1920&q=75',
      isNew: true
    },
    {
      id: 6,
      name: 'Nike Sportswear Tech Fleece',
      category: 'Easy On/Off Shoes',
      type: 'Unisex',
      price: 107,
      imageUrl: 'https://static.nike.com/a/images/t_web_pdp_535_v2/f_auto/b7b26b55-85c6-463a-8372-a10b9dba734f/AS+M+NSW+TCH+FLC+HOODIE+FZ+WR.png',
    },
    {
      id: 7,
      name: 'Kobe IX',
      category: 'Kids\' Junior Basketball Shoes',
      type: 'Kids',
      price: 112.33,
      imageUrl: 'https://static.nike.com/a/images/t_web_pdp_535_v2/f_auto/1d5f1d79-5768-40dd-bf44-3fefdbd67fa2/KOBE+IX+LOW+EM+%28GS%29.png',
    },
    {
      id: 8,
      name: 'Air Force 1',
      category: 'Women\'s Shoes',
      type: 'Women',
      price: 120,
      imageUrl: 'https://static.nike.com/a/images/t_web_pdp_535_v2/f_auto/56c2d024-9c01-4375-b77e-38efc360f7d4/WMNS+AIR+FORCE+1+%2707+LV8.png',
    },
    {
      id: 9,
      name: 'Nike Stephen Curry White Golden State Warriors Swingman Badge Player Jersey',
      category: 'Kids\' Shirt',
      type: 'Kids',
      price: 149.99,
      salePrice: 89.99,
      imageUrl: 'https://images.footballfanatics.com/golden-state-warriors/unisex-nike-stephen-curry-white-golden-state-warriors-swingman-badge-player-jersey-association-edition_pi5148000_altimages_ff_5148401-5798ce1e1461d0176d8dalt1_full.jpg?_hv=2&w=1018',
    },
     {
      id: 10,
      name: 'Nike Ja 3 Max Volume',
      category: 'Men\'s Running Shoes',
      type: 'Men',
      price: 131.20,
      imageUrl: 'https://i.ebayimg.com/images/g/oKcAAeSwC4Bos5AI/s-l1600.webp',
      isNew: true
    },
  ]);

  products = this._products.asReadonly();
  saleProducts = computed(() => this.products().filter(p => !!p.salePrice));

  getProductsByType(type: ProductCategoryType): Product[] {
    return this.products().filter(p => p.type === type);
  }

}