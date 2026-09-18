import { Component, OnInit, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { ProductService } from '../../services/product.service';
import { CartService } from '../../services/cart.service';
import { DemoService } from '../../services/demo.service';
import { ProductDetail } from '../../models/product';

@Component({
  selector: 'app-product-detail',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterLink],
  templateUrl: './product-detail.component.html',
})
export class ProductDetailComponent implements OnInit {
  private route = inject(ActivatedRoute);
  private productService = inject(ProductService);
  private cartService = inject(CartService);
  demo = inject(DemoService);

  product = signal<ProductDetail | null>(null);
  loading = signal(true);
  quantities: Record<number, number> = {};
  message = signal<string | null>(null);

  ngOnInit() {
    const id = Number(this.route.snapshot.paramMap.get('id'));

    this.productService.get(id).subscribe({
      next: (product) => {
        this.product.set(product);
        product.variants.forEach((v) => (this.quantities[v.id] = 1));
        this.loading.set(false);
      },
      error: () => this.loading.set(false),
    });
  }

  attributeLabel(variant: ProductDetail['variants'][number]): string {
    return variant.attributes.map((a) => `${a.name}: ${a.option}`).join(' | ');
  }

  addToCart(variantId: number) {
    const quantity = this.quantities[variantId] || 1;
    this.cartService.add(variantId, quantity).subscribe({
      next: () => {
        this.message.set('Produto adicionado ao carrinho!');
        setTimeout(() => this.message.set(null), 3000);
      },
    });
  }
}
