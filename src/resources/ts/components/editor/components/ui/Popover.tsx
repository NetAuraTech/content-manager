import { ComponentChildren, h } from "preact";
import { useState, useContext, useRef, useEffect } from "preact/hooks";
import {Children, createContext, CSSProperties, ReactElement} from "preact/compat";

interface PopoverContextType {
    isOpen: boolean;
    setOpen: (isOpen: boolean) => void;
    triggerRef: React.RefObject<HTMLElement>;
}
const PopoverContext = createContext<PopoverContextType | undefined>(undefined);

const usePopoverContext = () => {
    const context = useContext(PopoverContext);
    if (!context) {
        throw new Error('Popover components must be used within a Popover.Root');
    }
    return context;
};

interface PopoverRootProps {
    children: ComponentChildren;
    open?: boolean;
    onOpenChange?: (open: boolean) => void;
}
function PopoverRoot({ children, open, onOpenChange }: PopoverRootProps) {
    const [internalIsOpen, setInternalIsOpen] = useState(false);
    const isOpen = open !== undefined ? open : internalIsOpen;
    const triggerRef = useRef<HTMLElement>(null);

    const setOpen = (newOpen: boolean) => {
        if (onOpenChange) {
            onOpenChange(newOpen);
        } else {
            setInternalIsOpen(newOpen);
        }
    };

    return (
        <PopoverContext.Provider value={{ isOpen, setOpen, triggerRef }}>
            <div style={{ position: 'relative', display: 'inline-block' }}>
                {children}
            </div>
        </PopoverContext.Provider>
    );
}

interface PopoverTriggerProps {
    children: ComponentChildren;
    asChild?: boolean;
}
function PopoverTrigger({ children, asChild }: PopoverTriggerProps) {
    const { setOpen, triggerRef } = usePopoverContext();

    const handleClick = (e: Event) => {
        e.preventDefault();
        setOpen(true);
    };

    if (asChild) {
        const child = Children.only(children) as ReactElement;
        return h(child.type, {
            ...child.props,
            ref: (node: HTMLElement | null) => {
                (triggerRef as React.MutableRefObject<HTMLElement | null>).current = node;
                if (typeof child.ref === 'function') {
                    child.ref(node);
                } else if (child.ref) {
                    (child.ref as React.MutableRefObject<HTMLElement | null>).current = node;
                }
            },
            onClick: (e: Event) => {
                handleClick(e);
                if (child.props.onClick) child.props.onClick(e);
            },
        }, child.props.children);
    }

    return (
        <button ref={triggerRef as React.Ref<HTMLButtonElement>} onClick={handleClick}>
            {children}
        </button>
    );
}

interface PopoverContentProps {
    children: ComponentChildren;
    className?: string;
    style?: CSSProperties;
    side?: 'top' | 'bottom';
}
function PopoverContent({ children, className, style, side = 'bottom' }: PopoverContentProps) {
    const { isOpen, triggerRef, setOpen } = usePopoverContext();
    const contentRef = useRef<HTMLDivElement>(null);

    const contentStyle: CSSProperties = {
        position: 'absolute',
        zIndex: 1000,
        ...style,
    };

    useEffect(() => {
        if (isOpen && triggerRef.current && contentRef.current) {
            const triggerRect = triggerRef.current.getBoundingClientRect();
            const contentRect = contentRef.current.getBoundingClientRect();

            switch (side) {
                case 'top':
                    contentRef.current.style.top = `-${contentRect.height + triggerRect.height / 2 - 16}px`;
                    contentRef.current.style.left = `-${contentRect.width /2 - triggerRect.width / 2}px`;
                    break;
                case 'bottom':
                    contentRef.current.style.top = `${triggerRect.height + 4}px`;
                    contentRef.current.style.left = `-${contentRect.width /2 - triggerRect.width / 2}px`;
                    break;
            }
        }
    }, [isOpen, side, contentRef]);

    useEffect(() => {
        const handleClickOutside = (event: MouseEvent) => {
            if (contentRef.current && !contentRef.current.contains(event.target as Node) &&
                triggerRef.current && !triggerRef.current.contains(event.target as Node)) {
                setOpen(false);
            }
        };

        if (isOpen) {
            document.addEventListener('mousedown', handleClickOutside);
        } else {
            document.removeEventListener('mousedown', handleClickOutside);
        }

        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, [isOpen, setOpen, triggerRef]);


    if (!isOpen) return null;

    return (
        <div ref={contentRef} className={className} style={contentStyle}>
            {children}
        </div>
    );
}

export const Popover = {
    Root: PopoverRoot,
    Trigger: PopoverTrigger,
    Content: PopoverContent,
};
