import { usePage } from '@inertiajs/react';
import { toast } from 'sonner';
import { useEffect } from 'react';

type FlashMessage = {
  type: 'success' | 'error' | 'info' | 'warning';
  message: string;
};

type PageProps = {
  flash?: FlashMessage | null;
};

export function useFlash() {
  const { flash } = usePage().props as PageProps;

  useEffect(() => {
    if (flash) {
      // Display toast based on flash type
      switch (flash.type) {
        case 'success':
          toast.success(flash.message);
          break;
        case 'error':
          toast.error(flash.message);
          break;
        case 'warning':
          toast.warning(flash.message);
          break;
        default:
          toast.info(flash.message);
          break;
      }
    }
  }, [flash]);

  // Return the flash message for direct access if needed
  return flash;
}

export default useFlash;
