import {translate} from "@core-cms-shared/functions/i18n";
import {prevent} from "@core-cms-shared/functions/functions";
import {CSSProperties} from "preact/compat";


type Props = {
  onAction: Function
}

export function SidebarEmpty(data: Props) {

    return (
        <div className='grid padding-4 text-center' style={{overflowY: "auto", overflowX: "hidden"} as CSSProperties}>
            <p>{translate('content-manager.admin.editor.sidebar.empty')}</p>
            <div>
                <button
                    className="button"
                    data-type="primary"
                    onClick={prevent(data.onAction)}
                >
                    {translate('content-manager.admin.editor.sidebar.component.all')}
                </button>
            </div>
        </div>
    )
}
