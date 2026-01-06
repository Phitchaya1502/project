import { Component, ChangeDetectionStrategy } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HeroComponent } from '../hero/hero.component';
import { FeaturedProductsComponent } from '../featured-products/featured-products.component';
import { PromoSectionComponent } from '../promo-section/promo-section.component';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
  imports: [
    CommonModule,
    HeroComponent,
    FeaturedProductsComponent,
    PromoSectionComponent
  ]
})
export class HomeComponent {}
