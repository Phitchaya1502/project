import { Injectable, signal, computed } from '@angular/core';
import { Product } from '../models/product.model';

@Injectable({
  providedIn: 'root'
})
export class WishlistService {
  private readonly _wishlistItems = signal<Product[]>([]);

  wishlistItems = this._wishlistItems.asReadonly();
  wishlistCount = computed(() => this._wishlistItems().length);

  toggleWishlist(product: Product) {
    this._wishlistItems.update(items => {
      const existing = items.find(p => p.id === product.id);
      if (existing) {
        return items.filter(p => p.id !== product.id);
      } else {
        return [...items, product];
      }
    });
  }
}