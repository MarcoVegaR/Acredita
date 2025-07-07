import { Button } from "@/components/ui/button";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";
import { cn } from "@/lib/utils";
import { AlertCircle, AlertTriangle, Info } from "lucide-react";

type ConfirmModalProps = {
  open: boolean;
  onOpenChange: (open: boolean) => void;
  title: string;
  description: string | React.ReactNode;
  confirmText?: string;
  cancelText?: string;
  type?: "danger" | "warning" | "info";
  onConfirm: () => void;
  onCancel?: () => void;
  isLoading?: boolean;
};

export function ConfirmModal({
  open,
  onOpenChange,
  title,
  description,
  confirmText = "Confirmar",
  cancelText = "Cancelar",
  type = "info",
  onConfirm,
  onCancel,
  isLoading = false,
}: ConfirmModalProps) {
  // Define type-specific classes
  const typeClasses = {
    danger: {
      icon: AlertCircle,
      iconClass: "text-destructive",
      confirmClass: "bg-destructive text-destructive-foreground hover:bg-destructive/90",
    },
    warning: {
      icon: AlertTriangle,
      iconClass: "text-warning",
      confirmClass: "bg-warning text-warning-foreground hover:bg-warning/90",
    },
    info: {
      icon: Info,
      iconClass: "text-info",
      confirmClass: "bg-primary text-primary-foreground hover:bg-primary/90",
    },
  };

  const { icon: Icon, iconClass, confirmClass } = typeClasses[type];

  const handleConfirm = () => {
    onConfirm();
  };

  const handleCancel = () => {
    onOpenChange(false);
    onCancel?.();
  };

  return (
    <Dialog open={open} onOpenChange={onOpenChange}>
      <DialogContent className="sm:max-w-[425px]">
        <DialogHeader className="flex flex-row items-center gap-4">
          <div className="flex h-10 w-10 items-center justify-center rounded-full bg-muted">
            <Icon className={cn("h-5 w-5", iconClass)} />
          </div>
          <div className="flex flex-col gap-1">
            <DialogTitle>{title}</DialogTitle>
            {typeof description === "string" ? (
              <DialogDescription>{description}</DialogDescription>
            ) : (
              description
            )}
          </div>
        </DialogHeader>
        <DialogFooter className="flex flex-row items-center justify-end gap-2 sm:justify-end">
          <Button variant="outline" onClick={handleCancel} disabled={isLoading}>
            {cancelText}
          </Button>
          <Button
            className={confirmClass}
            onClick={handleConfirm}
            disabled={isLoading}
          >
            {isLoading ? "Procesando..." : confirmText}
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  );
}
