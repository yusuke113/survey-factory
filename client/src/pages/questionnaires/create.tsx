import { NextPage } from 'next';
import { createContext, useEffect } from 'react';
import { useRecoilState, useRecoilValue, useSetRecoilState } from 'recoil';
import { InputChoiceArea } from '../../components/formParts/InputChoiceArea';
// import { InputImage } from '../../components/formParts/InputImage';
import { InputTag } from '../../components/formParts/InputTag';
import { InputText } from '../../components/formParts/InputText';
import { QreChoice } from '../../domain/models/qreChoice';
import { StoreQuestionnaireProps } from '../../domain/useCaseProps/questionnaire/storeQuestionnaireProps';
import { addTagListState } from '../../states/atoms/addTagListAtom';
import { inputDescriptionState } from '../../states/atoms/inputDescriptionAtom';
import { inputTitleState } from '../../states/atoms/inputTitleAtom';
import { inputDescriptionLengthState } from '../../states/selectors/inputDescriptionLengthSelector';
import { inputTitleLengthState } from '../../states/selectors/inputTitleLengthSelector';
import styles from '../../styles/Home.module.scss';
import form_styles from '../../styles/components/formParts/Form.module.scss';
import { QuestionnaireUseCase } from '../../useCase/questionnaireUseCase';
import { validation } from '../../utils/validation';
import { errorMessageState } from '../../states/atoms/errorMessageAtom';
import { addChoiceListState } from '../../states/atoms/addChoiceListAtom';

const questionnaireUseCase = new QuestionnaireUseCase();

export const ErrorMessage = createContext({});

const QuestionnaireCreatePage: NextPage = () => {
  // タイトルのテキストフィールドと文字数のstate
  const [inputTitle, setInputTitle] = useRecoilState(inputTitleState);
  const inputTitleLength = useRecoilValue(inputTitleLengthState);

  // 説明文のテキストフィールドと文字数のstate
  const [inputDescription, setInputDescription] = useRecoilState(inputDescriptionState);
  const inputDescriptionLength = useRecoilValue(inputDescriptionLengthState);

  // 追加されたタグリストとそのリストに含まれるタグの個数
  const [addTagList, setAddTagList] = useRecoilState(addTagListState);

  // 選択肢配列のstateのセッター関数
  const setAddChoiceList = useSetRecoilState(addChoiceListState);

  // エラーメッセージを更新するセッター関数
  const setErrorMessage = useSetRecoilState(errorMessageState);

  // recoilで管理してるフィールドの初期化
  useEffect(() => {
    setInputTitle('');
    setInputDescription('');
    setAddTagList([]);
    setAddChoiceList([
      {
        body: '',
        displayOrder: 1,
      },
      {
        body: '',
        displayOrder: 2,
      },
    ]);
    setErrorMessage({});
  }, []);

  const submitButton = async () => {
    if (Object.keys(validation()).length) {
      setErrorMessage(validation());
      return;
    }

    const questionnaire: StoreQuestionnaireProps = {
      userId: 11,
      title: inputTitle,
      description: inputDescription,
      thumbnailUrl: '',
      qreChoices: setChoices(),
      tags: addTagList,
    };

    // アンケート登録APIを実行する
    const { data } = await questionnaireUseCase.storeQuestionnaire(questionnaire);
    const message = data.message;

    // RecoilのStateをリセットする
    recoilStateReset();

    // TODO: マイページにリダイレクト
    alert(`${message}\nTODO: マイページの自分の作ったアンケート一覧にリダイレクトする予定`);
  };

  // アンケートSubmit後、選択肢のオブジェクトを生成する
  const setChoices = (): Omit<QreChoice, 'id' | 'voteCount'>[] => {
    const choices = [...document.querySelectorAll('input[name^=choice]')] as HTMLInputElement[];

    const newList = choices.map((choice, index) => {
      return {
        body: choice.value,
        displayOrder: index + 1,
      };
    });

    return newList;
  };

  // アンケートSubmiｔ完了後、RecoilのStateをリセットする
  const recoilStateReset = () => {
    setInputTitle('');
    setInputDescription('');
    setAddTagList([]);
    setAddChoiceList([
      {
        body: '',
        displayOrder: 1,
      },
      {
        body: '',
        displayOrder: 2,
      },
    ]);
    setErrorMessage({});
  };

  return (
    <>
      <div className={styles.questionnaire_create}>
        <div className={styles.content_inner}>
          <div className={styles.questionnaire_container}>
            <section className={styles.questionnaire_section}>
              <h3>アンケートのタイトル</h3>
              <p className={styles.description}>
                アンケートのタイトルと簡潔な説明を設定してください
              </p>
              <InputText
                title="タイトル"
                id="title"
                name="title"
                placeholder="例：目玉焼きには醤油派？ソース派"
                maxLength={30}
                validationName="タイトル"
                inputText={inputTitle}
                setInputText={setInputTitle}
                inputTextLength={inputTitleLength}
              />
              <InputText
                title="アンケートのかんたんな説明"
                id="description"
                name="description"
                placeholder="例：目玉焼きにかける調味料は醤油が好き？それともソースが好き？"
                maxLength={50}
                validationName="アンケート説明文"
                inputText={inputDescription}
                setInputText={setInputDescription}
                inputTextLength={inputDescriptionLength}
              />
            </section>
            <section className={styles.questionnaire_section}>
              <h3>タグを設定</h3>
              <p className={styles.description}>アンケートに設定するタグを3つまで設定できます</p>
              <InputTag
                title="タグ"
                id="tagName"
                name="tagName"
                placeholder="例：アニメ クレヨンしんちゃん 映画"
                maxLength={20}
              />
            </section>
            {/* <section className={styles.questionnaire_section}>
              <h3>サムネイル</h3>
              <p className={styles.description}>SNSにシェアされたとき表示される画像を設定できます</p>
              <InputImage
                title="サムネイル画像をアップロードする"
                id="thumbnail"
                name="thumbnail"
              />
            </section> */}
            <section className={styles.questionnaire_section}>
              <h3>選択肢を追加</h3>
              <p className={styles.description}>
                アンケートの設問に対する選択肢を追加してください。
              </p>
              <InputChoiceArea title="選択肢を追加" />
            </section>
            <section className={styles.questionnaire_section}>
              <button className={form_styles.submit_button} onClick={() => submitButton()}>
                アンケートを公開する
              </button>
            </section>
          </div>
        </div>
      </div>
    </>
  );
};

export default QuestionnaireCreatePage;
