import { Component, ChangeDetectionStrategy, computed, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute } from '@angular/router';
import { toSignal } from '@angular/core/rxjs-interop';
import { map } from 'rxjs/operators';
import { ProductService } from '../../services/product.service';
import { ProductCategoryType } from '../../models/product.model';
import { ProductCardComponent } from '../product-card/product-card.component';

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
  standalone: true,
  imports: [CommonModule, ProductCardComponent]
})
export class ProductListComponent {
  private route = inject(ActivatedRoute);
  private productService = inject(ProductService);
  
  private categoryName = toSignal(this.route.paramMap.pipe(map(params => params.get('name'))));

  categoryTitle = computed(() => {
    const name = this.categoryName();
    return name ? name.charAt(0).toUpperCase() + name.slice(1) : 'Products';
  });

  products = computed(() => {
    const name = this.categoryName();
    if (!name) return [];
    
    const type = name.charAt(0).toUpperCase() + name.slice(1) as ProductCategoryType;
    if (['Men', 'Women', 'Kids', 'Unisex'].includes(type)) {
       return this.productService.getProductsByType(type);
    }
    return [];
  });
}