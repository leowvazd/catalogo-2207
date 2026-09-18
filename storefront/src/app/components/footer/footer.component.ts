import { Component } from '@angular/core';

@Component({
  selector: 'app-footer',
  standalone: true,
  templateUrl: './footer.component.html',
})
export class FooterComponent {
  readonly year = new Date().getFullYear();
  readonly instagramUrl = 'https://www.instagram.com/__lessenzza/';
  readonly whatsappUrl = 'https://api.whatsapp.com/message/YS2YNNQJGPCTC1?autoload=1&app_absent=0';
}
