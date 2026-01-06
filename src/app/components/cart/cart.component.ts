import { Component, ChangeDetectionStrategy, inject } from '@angular/core';
import { CommonModule, NgOptimizedImage } from '@angular/common';
import { CartService } from '../../services/cart.service';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
  standalone: true,
  imports: [CommonModule, NgOptimizedImage, RouterModule]
})
export class CartComponent {
  cartService = inject(CartService);
  cartItems = this.cartService.cartItems;
  cartTotal = this.cartService.cartTotal;

  removeFromCart(productId: number): void {
    this.cartService.removeFromCart(productId);
  }
}