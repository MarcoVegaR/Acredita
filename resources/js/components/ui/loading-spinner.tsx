import { cn } from "@/lib/utils";
import React from "react";

type LoadingSpinnerProps = {
  size?: "sm" | "md" | "lg";
  color?: "default" | "primary" | "success" | "warning" | "danger";
  text?: string;
  className?: string;
};

export function LoadingSpinner({
  size = "md",
  color = "primary",
  text,
  className,
}: LoadingSpinnerProps) {
  // Define size classes
  const sizeClasses = {
    sm: "h-4 w-4 border-2",
    md: "h-8 w-8 border-3",
    lg: "h-12 w-12 border-4",
  };

  // Define color classes
  const colorClasses = {
    default: "border-muted-foreground/30 border-t-muted-foreground",
    primary: "border-primary/30 border-t-primary",
    success: "border-success/30 border-t-success",
    warning: "border-warning/30 border-t-warning",
    danger: "border-destructive/30 border-t-destructive",
  };

  return (
    <div className="flex flex-col items-center justify-center">
      <div
        className={cn(
          "animate-spin rounded-full border-solid",
          sizeClasses[size],
          colorClasses[color],
          className
        )}
      />
      {text && <p className="mt-2 text-sm text-muted-foreground">{text}</p>}
    </div>
  );
}

// Overlay version that covers an entire area
type LoadingOverlayProps = {
  loading: boolean;
  children: React.ReactNode;
  spinnerProps?: LoadingSpinnerProps;
  className?: string;
};

export function LoadingOverlay({
  loading,
  children,
  spinnerProps,
  className,
}: LoadingOverlayProps) {
  return (
    <div className={cn("relative", className)}>
      {children}
      {loading && (
        <div className="absolute inset-0 flex items-center justify-center bg-background/70 backdrop-blur-sm">
          <LoadingSpinner {...spinnerProps} />
        </div>
      )}
    </div>
  );
}
