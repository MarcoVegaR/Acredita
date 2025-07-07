import { cn } from "@/lib/utils";
import React from "react";

import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";

type StatsCardProps = {
  title: string;
  value: string | number;
  icon?: React.ComponentType<{ className?: string }>;
  description?: string;
  trend?: {
    value: number;
    type: "increase" | "decrease" | "neutral";
  };
  variant?: "default" | "primary" | "success" | "warning" | "danger";
  className?: string;
};

export function StatsCard({
  title,
  value,
  icon: Icon,
  description,
  trend,
  variant = "default",
  className,
}: StatsCardProps) {
  // Define variant-specific classes
  const variantClasses = {
    default: "",
    primary: "border-primary/30",
    success: "border-success/30",
    warning: "border-warning/30",
    danger: "border-destructive/30",
  };

  // Define trend colors
  const trendColors = {
    increase: "text-success",
    decrease: "text-destructive",
    neutral: "text-muted-foreground",
  };

  // Format trend value with '+' or '-' prefix
  const formattedTrendValue = trend
    ? trend.type === "increase"
      ? `+${trend.value}%`
      : trend.type === "decrease"
      ? `-${trend.value}%`
      : `${trend.value}%`
    : null;

  return (
    <Card
      className={cn(
        "overflow-hidden transition-all hover:shadow-md",
        variantClasses[variant],
        className
      )}
    >
      <CardHeader className="flex flex-row items-center justify-between pb-2 space-y-0">
        <CardTitle className="text-sm font-medium text-muted-foreground">
          {title}
        </CardTitle>
        {Icon && (
          <Icon
            className={cn(
              "h-5 w-5 text-muted-foreground",
              variant === "primary" && "text-primary",
              variant === "success" && "text-success",
              variant === "warning" && "text-warning",
              variant === "danger" && "text-destructive"
            )}
          />
        )}
      </CardHeader>
      <CardContent>
        <div className="text-2xl font-bold">{value}</div>
        {trend && (
          <div className="flex items-center mt-1 text-sm">
            <span
              className={cn("font-medium", trendColors[trend.type])}
            >
              {formattedTrendValue}
            </span>
          </div>
        )}
      </CardContent>
      {description && (
        <CardFooter className="pt-0 text-xs text-muted-foreground">
          <CardDescription>{description}</CardDescription>
        </CardFooter>
      )}
    </Card>
  );
}
