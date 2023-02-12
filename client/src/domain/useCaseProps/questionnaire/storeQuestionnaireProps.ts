import { QreChoice } from "../../models/qreChoice";
import { Tag } from "../../models/tag";

export interface StoreQuestionnaireProps {
  userId: number;
  title: string;
  description: string;
  thumbnailUrl: string;
  qreChoices: Omit<QreChoice, 'id' | 'voteCount'>[];
  tags: Tag[];
}