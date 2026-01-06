import { Component, ChangeDetectionStrategy, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { CartService } from '../../services/cart.service';
import { WishlistService } from '../../services/wishlist.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
  standalone: true,
  imports: [CommonModule, RouterModule]
})
export class HeaderComponent {
  private cartService = inject(CartService);
  private wishlistService = inject(WishlistService);

  cartCount = this.cartService.cartCount;
  wishlistCount = this.wishlistService.wishlistCount;
}