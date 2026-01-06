import { Component, ChangeDetectionStrategy, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { WishlistService } from '../../services/wishlist.service';
import { ProductCardComponent } from '../product-card/product-card.component';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-wishlist',
  templateUrl: './wishlist.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
  standalone: true,
  imports: [CommonModule, ProductCardComponent, RouterModule]
})
export class WishlistComponent {
  wishlistService = inject(WishlistService);
  wishlistItems = this.wishlistService.wishlistItems;
}