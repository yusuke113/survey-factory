import { NextPage } from 'next';
import { createContext, useState } from 'react';
import { useRecoilState, useRecoilValue } from 'recoil';
import { InputChoiceArea } from '../../components/formParts/InputChoiceArea';
import { InputImage } from '../../components/formParts/InputImage';
import { InputTag } from '../../components/formParts/InputTag';
import { InputText } from '../../components/formParts/InputText';
import { QreChoice } from '../../domain/models/qreChoice';
import { StoreQuestionnaireProps } from '../../domain/useCaseProps/questionnaire/storeQuestionnaireProps';
import { addChoiceListState } from '../../states/atoms/addChoiceListAtom';
import { addTagListState } from '../../states/atoms/addTagListAtom';
import { inputDescriptionState } from '../../states/atoms/inputDescriptionAtom';
import { inputTitleState } from '../../states/atoms/inputTitleAtom';
import { inputDescriptionLengthState } from '../../states/selectors/inputDescriptionLengthSelector';
import { inputTitleLengthState } from '../../states/selectors/inputTitleLengthSelector';
import styles from '../../styles/Home.module.scss';
import form_styles from '../../styles/components/formParts/Form.module.scss';
import { QuestionnaireUseCase } from '../../usecase/questionnaireUseCase';
import { validation } from '../../utils/validation';

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
  const addTagList = useRecoilValue(addTagListState);

  // 選択肢リストのstate
  const [addChoiceList, setAddChoiceList] = useRecoilState(addChoiceListState);

  const [error, setError] = useState({});

  const submitButton = async () => {
    if (Object.keys(validation()).length) {
      setError(validation());
      console.log(validation());
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

    console.log(questionnaire);

    const { data } = await questionnaireUseCase.storeQuestionnaire(questionnaire);
    const message = data.message;
    console.log(data);

    alert(`${message}\nTODO: マイページの自分の作ったアンケート一覧にリダイレクトする予定`);
  };

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

  const errorButton = () => {
    console.log(error.title);
  };

  const testButton = () => {
    console.log(addChoiceList);
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
              <ErrorMessage.Provider value={ErrorMessage}>
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
              </ErrorMessage.Provider>
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
            <button className={form_styles.submit_button} onClick={() => errorButton()}>
              デバッグエラー
            </button>
            <button className={form_styles.submit_button} onClick={() => testButton()}>
              テストボタン
            </button>
          </div>
        </div>
      </div>
    </>
  );
};

export default QuestionnaireCreatePage;
