import {EditorComponentData} from "../../types";
import {JSX} from "preact";
import {createPortal, useEffect, useRef, useState} from "preact/compat";
import {usePreviewMode} from "../../store";
import {PreviewModes} from "../../enum";
import {PHONE_HEIGHT} from "../../constants";
import {useAsyncEffect} from "../../../../functions/hooks";
import {PreviewItems} from "./previewItems";
import {useWindowSize} from '@core-cms-shared/functions/window';


type PreviewProps = {
    data: EditorComponentData[]
    previewUrl: string
}

export function Preview({data, previewUrl}: PreviewProps): JSX {
    const iframe = useRef<HTMLIFrameElement | null>(null)
    const [iframeRoot, setIframeRoot] = useState<HTMLElement | null>(null)
    const initialHTML = useRef<Record<string, string>>({})
    const [loaded, setLoaded] = useState(false)
    const showSpinner = !loaded
    const previewMode = usePreviewMode()
    const {height: windowHeight} = useWindowSize()
    let transform = undefined

    if (previewMode === PreviewModes.PHONE && windowHeight < 844) {
        transform = {transform: `scale(${windowHeight / PHONE_HEIGHT})`}
    }

    useAsyncEffect(async () => {
        setLoaded(false)
        const r = await fetch(previewUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
            body: JSON.stringify(data),
        })
        if (!r.ok) {
            return
        }

        const iframeDocument = iframe.current!.contentDocument!;

        iframeDocument?.open();
        iframeDocument?.write(await r.text());
        iframeDocument?.close();
        setLoaded(true)
    }, [])

    useEffect(() => {
        if(loaded) {
            const iframeDocument = iframe.current!.contentDocument!

            iframeDocument.addEventListener('DOMContentLoaded', () => {
                const root = iframeDocument.querySelector('#ve-components') as HTMLElement;
                if (root) {
                    initialHTML.current = Array.from(root.children).reduce(
                        (acc, v, k) => ({ ...acc, [data[k]!._id]: v.outerHTML }),
                        {},
                    );
                    root.innerHTML = '';
                    setIframeRoot(root);
                }
            });
        }
    }, [loaded])

    return (
        <div className={'preview'}>
            {showSpinner && <div className="loader__wrapper"><span className="loader"></span></div>}
            <iframe
                className={`${loaded ? 'loaded' : ''} ${
                    previewMode === PreviewModes.PHONE ? 'mobile' : ''
                }`}
                ref={iframe}
                style={transform}
                onLoad={() => setLoaded(true)}
            />
            {iframeRoot &&
                createPortal(
                    <PreviewItems
                        data={data}
                        initialHTML={initialHTML.current}
                        previewUrl={previewUrl}
                    />,
                    iframeRoot,
                )}
        </div>
    )
}
