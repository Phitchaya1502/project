import { Component, ChangeDetectionStrategy, input, inject, computed } from '@angular/core';
import { CommonModule, NgOptimizedImage } from '@angular/common';
import { Product } from '../../models/product.model';
import { CartService } from '../../services/cart.service';
import { WishlistService } from '../../services/wishlist.service';

@Component({
  selector: 'app-product-card',
  templateUrl: './product-card.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
  standalone: true,
  imports: [CommonModule, NgOptimizedImage]
})
export class ProductCardComponent {
  product = input.required<Product>();
  
  private cartService = inject(CartService);
  private wishlistService = inject(WishlistService);

  isInWishlist = computed(() => 
    this.wishlistService.wishlistItems().some(p => p.id === this.product().id)
  );

  addToCart(product: Product): void {
    this.cartService.addToCart(product);
  }

  toggleWishlist(product: Product): void {
    this.wishlistService.toggleWishlist(product);
  }
}