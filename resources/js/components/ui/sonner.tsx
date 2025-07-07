import { useTheme } from "next-themes"
import { Toaster as Sonner, ToasterProps } from "sonner"

const Toaster = ({ ...props }: ToasterProps) => {
  const { theme = "system" } = useTheme()

  return (
    <Sonner
      theme={theme as ToasterProps["theme"]}
      className="toaster group rounded-lg border border-border shadow-lg"
      toastOptions={{
        classNames: {
          toast: "group toast rounded-lg border border-border bg-background text-foreground",
          title: "text-foreground font-semibold",
          description: "text-muted-foreground",
          actionButton: "bg-primary text-primary-foreground",
          cancelButton: "bg-muted text-muted-foreground",
          closeButton: "text-foreground/50 hover:text-foreground",
          success: "bg-success/10 text-success border-success/30",
          error: "bg-destructive/10 text-destructive border-destructive/30",
          info: "bg-info/10 text-info border-info/30",
          warning: "bg-warning/10 text-warning border-warning/30",
        },
      }}
      style={{
        "--normal-bg": "var(--popover)",
        "--normal-text": "var(--popover-foreground)",
        "--normal-border": "var(--border)",
        "--success-bg": "var(--success)",
        "--success-text": "var(--success-foreground)",
        "--error-bg": "var(--destructive)", 
        "--error-text": "var(--destructive-foreground)",
        "--loading-bg": "var(--muted)",
        "--loading-text": "var(--muted-foreground)",
      } as React.CSSProperties}
      {...props}
    />
  )
}

export { Toaster }
