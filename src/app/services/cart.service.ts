import { Injectable, signal, computed } from '@angular/core';
import { Product } from '../models/product.model';

@Injectable({
  providedIn: 'root'
})
export class CartService {
  private readonly _cartItems = signal<Product[]>([]);

  cartItems = this._cartItems.asReadonly();
  cartCount = computed(() => this._cartItems().length);
  cartTotal = computed(() => this._cartItems().reduce((acc, item) => acc + (item.salePrice ?? item.price), 0));

  addToCart(product: Product) {
    this._cartItems.update(items => {
      // Avoid adding duplicates
      if (items.find(p => p.id === product.id)) {
        return items;
      }
      return [...items, product];
    });
  }

  removeFromCart(productId: number) {
    this._cartItems.update(items => items.filter(p => p.id !== productId));
  }
}