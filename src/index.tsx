import { createRoot } from 'react-dom/client';
import { StrictMode } from 'react';
import { App } from './App';
import {
  QueryClient,
  QueryClientProvider,
} from '@tanstack/react-query';

let container = document.getElementById("app")!;
let root = createRoot(container)
const queryClient = new QueryClient();

root.render(
  <StrictMode>
     <QueryClientProvider client={queryClient}>
    <App predata={['','',0]}/>
    </QueryClientProvider>
  </StrictMode>
);

