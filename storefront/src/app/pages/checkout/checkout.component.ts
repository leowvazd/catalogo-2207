import { Component, inject, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { CartService } from '../../services/cart.service';
import { OrderService } from '../../services/order.service';
import { CheckoutPayload } from '../../models/cart';

@Component({
  selector: 'app-checkout',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './checkout.component.html',
})
export class CheckoutComponent {
  cartService = inject(CartService);
  private orderService = inject(OrderService);
  private router = inject(Router);

  submitting = signal(false);
  error = signal<string | null>(null);

  form: CheckoutPayload = {
    name: '',
    phone: '',
    email: '',
    cnpjcpf: '',
    postalcode: '',
    address: '',
    number: '',
    city: '',
    state: '',
  };

  submit() {
    this.submitting.set(true);
    this.error.set(null);

    this.orderService.checkout(this.form).subscribe({
      next: (order) => {
        this.router.navigate(['/pedido', order.id]);
      },
      error: (err) => {
        this.submitting.set(false);
        this.error.set(err?.error?.message ?? 'Não foi possível concluir o pedido. Tente novamente.');
      },
    });
  }
}
