import {EditorComponentDefinition} from "../../types";
import {prevent} from "@core-cms-shared/functions/functions";
import {CSSProperties} from "preact/compat";


export function BlocSelectorItem({
                                     definition,
                                     name,
                                     iconsUrl,
                                     onClick,
                                 }: {
    name: string
    definition: EditorComponentDefinition
    iconsUrl: string
    onClick: () => void
}) {
    const icon = iconsUrl.replace('[name]', name)
    const title = definition.title

    return (
        <button
            className={'grid button padding-0'}
            data-type="transparent"
            onClick={prevent(onClick)}
            title={definition.title}
            style={{    gridTemplateRows: "1fr auto"} as CSSProperties}
        >
            <img src={icon} alt='' width={280} height={80} />
            <h3 className="heading-3">{title}</h3>
        </button>
    )
}
