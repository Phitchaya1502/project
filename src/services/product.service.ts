import { Injectable, signal, computed } from '@angular/core';
import { Product, ProductCategoryType } from '../models/product.model';

@Injectable({
  providedIn: 'root'
})
export class ProductService {
  private readonly _products = signal<Product[]>([
    {
      id: 1,
      name: 'Aura Zoom Pegasus 41',
      category: 'Men\'s Road Running Shoes',
      type: 'Men',
      price: 140,
      imageUrl: 'https://picsum.photos/id/10/800/800',
      isNew: true
    },
    {
      id: 2,
      name: 'Aura Air Max 90',
      category: 'Women\'s Shoes',
      type: 'Women',
      price: 130,
      salePrice: 99.99,
      imageUrl: 'https://picsum.photos/id/20/800/800',
    },
    {
      id: 3,
      name: 'Aura Revolution 7',
      category: 'Men\'s Road Running Shoes',
      type: 'Men',
      price: 75,
      imageUrl: 'https://picsum.photos/id/30/800/800',
    },
    {
      id: 4,
      name: 'Aura Dunk Low Retro',
      category: 'Men\'s Shoes',
      type: 'Men',
      price: 115,
      imageUrl: 'https://picsum.photos/id/40/800/800',
    },
    {
      id: 5,
      name: 'Aura Invincible 3',
      category: 'Women\'s Road Running Shoes',
      type: 'Women',
      price: 180,
      imageUrl: 'https://picsum.photos/id/50/800/800',
      isNew: true
    },
    {
      id: 6,
      name: 'Aura Go FlyEase',
      category: 'Easy On/Off Shoes',
      type: 'Unisex',
      price: 125,
      imageUrl: 'https://picsum.photos/id/60/800/800',
    },
    {
      id: 7,
      name: 'Aura Flex Runner',
      category: 'Kids\' Shoes',
      type: 'Kids',
      price: 55,
      imageUrl: 'https://picsum.photos/id/11/800/800',
    },
    {
      id: 8,
      name: 'Aura Air Force 1',
      category: 'Women\'s Shoes',
      type: 'Women',
      price: 110,
      imageUrl: 'https://picsum.photos/id/21/800/800',
    },
    {
      id: 9,
      name: 'Aura Blazer Mid \'77',
      category: 'Kids\' Shoes',
      type: 'Kids',
      price: 90,
      salePrice: 75.00,
      imageUrl: 'https://picsum.photos/id/31/800/800',
    },
     {
      id: 10,
      name: 'Aura InfinityRN 4',
      category: 'Men\'s Running Shoes',
      type: 'Men',
      price: 160,
      imageUrl: 'https://picsum.photos/id/41/800/800',
      isNew: true
    },
  ]);

  products = this._products.asReadonly();
  saleProducts = computed(() => this.products().filter(p => !!p.salePrice));

  getProductsByType(type: ProductCategoryType): Product[] {
    return this.products().filter(p => p.type === type);
  }

}