import {useUniqId} from "@core-cms-shared/functions/hooks";
import {defineField} from "./utils";
import {Field} from "../ui/field";
import {JSX} from "preact";

export type MediaFieldArgs = {
    label?: string
    default?: string,
    canAnimate?: boolean
}

const Component: ({value, onChange, options}: { value: any; onChange: any; options: any }) => JSX.Element = ({
                                                          value,
                                                          onChange,
                                                          options,
                                                      }) => {
    const id = useUniqId('media-input')

    return (
        <Field
            id={id}
            label={options.label}
            type="media"
            value={value}
            onInput={e => onChange((e.target as HTMLInputElement).value)}
        />
    )
}

export const Media = defineField<MediaFieldArgs, string>({
    defaultOptions: {
        default: '',
        canAnimate: false
    },
    render: Component,
})
