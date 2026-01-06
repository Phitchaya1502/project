import { Component, ChangeDetectionStrategy, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute } from '@angular/router';
import { toSignal } from '@angular/core/rxjs-interop';
import { map } from 'rxjs/operators';

@Component({
  selector: 'app-info-page',
  templateUrl: './info-page.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
  imports: [CommonModule],
  standalone: true
})
export class InfoPageComponent {
  private route = inject(ActivatedRoute);
  
  title = toSignal(
    this.route.data.pipe(map(data => data['title'] || 'Information'))
  );
  
  content = toSignal(
    this.route.data.pipe(map(data => data['content'] || 'Content for this page is under construction.'))
  );
}