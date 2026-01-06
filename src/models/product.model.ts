export type ProductCategoryType = 'Men' | 'Women' | 'Kids' | 'Unisex';

export interface Product {
  id: number;
  name: string;
  category: string; // e.g. "Men's Road Running Shoes"
  type: ProductCategoryType;
  price: number;
  salePrice?: number;
  imageUrl: string;
  isNew?: boolean;
}
