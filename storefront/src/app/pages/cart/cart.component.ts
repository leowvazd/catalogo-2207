import { Component, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { CartService } from '../../services/cart.service';

@Component({
  selector: 'app-cart',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterLink],
  templateUrl: './cart.component.html',
})
export class CartComponent {
  cartService = inject(CartService);

  updateQuantity(variantId: number, quantity: number) {
    this.cartService.update(variantId, quantity).subscribe();
  }

  remove(variantId: number) {
    this.cartService.remove(variantId).subscribe();
  }

  clear() {
    this.cartService.clear().subscribe();
  }
}
