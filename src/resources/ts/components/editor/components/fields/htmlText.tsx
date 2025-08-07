import { useEffect, useRef } from 'preact/hooks'
import Quill from 'quill'
import 'quill/dist/quill.snow.css'
import { defineField } from './utils'

const ColorClass = Quill.import('attributors/style/color')
Quill.register(ColorClass, true)

export type HtmlTextFieldArgs = {
    label?: string
    default?: string
    canAnimate?: boolean
}

function addHeadingClassesToHTML(html: string): string {
    const div = document.createElement('div');
    div.innerHTML = html;

    for (let level = 1; level <= 6; level++) {
        div.querySelectorAll(`h${level}`).forEach((el) => {
            el.classList.add(`heading-${level}`);
            el.classList.add(`margin-block-end-6`);
        })
    }

    return div.innerHTML;
}

const Component = ({
                       value,
                       onChange,
                       options,
                   }: {
    value: string
    onChange: (val: string) => void
    options: HtmlTextFieldArgs
}) => {
    const containerRef = useRef<HTMLDivElement | null>(null);
    const editorRef = useRef<Quill | null>(null);

    const getColorOptions = () => {
        if (!options.colors || options.colors.length === 0) return undefined
        return options.colors;
    }

    useEffect(() => {
        if (containerRef.current && !editorRef.current) {
            editorRef.current = new Quill(containerRef.current, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ header: [1, 2, 3, 4, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        [{ align: [] }],
                        [{ color: getColorOptions() }],
                        ['link'],
                        ['clean'],
                    ],
                },
            })

            editorRef.current.root.innerHTML = value || '';

            editorRef.current.on('text-change', () => {
                const rawHTML = editorRef.current!.root.innerHTML;
                const htmlWithClasses = addHeadingClassesToHTML(rawHTML);
                onChange(htmlWithClasses);
            });

            setTimeout(() => {
                editorRef.current.container.style.height = '200px';
                const colorPickers = document.querySelectorAll('.ql-color .ql-picker-options');
                colorPickers.forEach((picker) => {
                    (picker as HTMLElement).style.width = '192px';
                })
            }, 0)
        }
    }, [])

    useEffect(() => {
        if (editorRef.current) {
            const rawHTML = editorRef.current.root.innerHTML;
            const incoming = value || '';

            if (rawHTML !== incoming) {
                editorRef.current.root.innerHTML = incoming;
            }
        }
    }, [value])

    return (
        <div className="form-group">
            {options.label && <label>{options.label}</label>}
            <div className="form-control">
                <div ref={containerRef} />
            </div>
        </div>
    )
}

export const HtmlText = defineField<HtmlTextFieldArgs, string>({
    defaultOptions: {
        default: '',
        canAnimate: false,
    },
    render: Component,
})